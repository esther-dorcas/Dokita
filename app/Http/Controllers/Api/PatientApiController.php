<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\RendezVous;
use App\Models\Hopital;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class PatientApiController extends Controller
{
    /**
     * Récupère les données du dashboard patient
     * 
     * @return JsonResponse
     */
    public function dashboard(): JsonResponse
    {
        $userId = Auth::id();

        // Prochains rendez-vous
        $upcomingRendezVous = RendezVous::with('medecin.hopital', 'medecin.user')
            ->where('patient_id', $userId)
            ->where('date_heure', '>=', now())
            ->orderBy('date_heure')
            ->take(4)
            ->get()
            ->map(fn($rdv) => [
                'id' => $rdv->id,
                'date_heure' => $rdv->date_heure->isoFormat('ddd D MMM YYYY [à] HH[h]mm'),
                'date_heure_iso' => $rdv->date_heure->toIso8601String(),
                'medecin' => [
                    'id' => $rdv->medecin->id,
                    'nom' => 'Dr. ' . $rdv->medecin->user->name,
                    'specialite' => $rdv->medecin->specialite,
                ],
                'hopital' => $rdv->medecin->hopital ? [
                    'id' => $rdv->medecin->hopital->id,
                    'nom' => $rdv->medecin->hopital->nom,
                    'adresse' => $rdv->medecin->hopital->adresse,
                ] : null,
                'statut' => $rdv->statut,
                'statut_label' => match($rdv->statut) {
                    'confirme' => 'Confirmé',
                    'en_attente' => 'En attente',
                    default => 'Annulé'
                },
            ]);

        // Statistiques
        $stats = [
            'upcoming' => RendezVous::where('patient_id', $userId)
                ->where('date_heure', '>=', now()->toDateTimeString())
                ->count(),
            'confirmed' => RendezVous::where('patient_id', $userId)
                ->where('statut', 'confirme')
                ->count(),
            'completed' => RendezVous::where('patient_id', $userId)
                ->where('date_heure', '<', now()->toDateTimeString())
                ->count(),
            'hopitaux_count' => RendezVous::with('medecin.hopital')
                ->where('patient_id', $userId)
                ->get()
                ->map(fn($rdv) => $rdv->medecin->hopital)
                ->filter()
                ->unique('id')
                ->count(),
        ];

        // Hôpitaux récents
        $recentHopitaux = RendezVous::with('medecin.hopital')
            ->where('patient_id', $userId)
            ->latest('date_heure')
            ->get()
            ->map(fn($rdv) => $rdv->medecin->hopital)
            ->filter()
            ->unique('id')
            ->take(3)
            ->values()
            ->map(fn($hopital) => [
                'id' => $hopital->id,
                'nom' => $hopital->nom,
                'adresse' => $hopital->adresse,
                'telephone' => $hopital->telephone,
            ]);

        // Notifications (simulées basées sur les RDV à venir)
        $notifications = $upcomingRendezVous->map(fn($rdv) => [
            'id' => uniqid(),
            'title' => 'Rendez-vous à venir',
            'message' => 'Demain à '.now()->addDay()->format('H:i').' avec '.$rdv['medecin']['nom'],
            'time' => now()->diffForHumans(),
            'type' => 'rdv',
            'read' => false,
        ])->values();

        return response()->json([
            'success' => true,
            'data' => [
                'user' => [
                    'id' => Auth::user()->id,
                    'name' => Auth::user()->name,
                    'email' => Auth::user()->email,
                ],
                'stats' => $stats,
                'upcoming_rdv' => $upcomingRendezVous,
                'recent_hopitaux' => $recentHopitaux,
                'notifications' => $notifications,
            ]
        ]);
    }

    // Récupère la liste des rendez-vous du patient
    public function rendezVous(): JsonResponse
    {
        $userId = Auth::id();

        $rendezVous = RendezVous::with('medecin.hopital', 'medecin.user')
            ->where('patient_id', $userId)
            ->orderBy('date_heure', 'desc')
            ->get()
            ->map(fn($rdv) => [
                'id' => $rdv->id,
                'date_heure' => $rdv->date_heure->isoFormat('ddd D MMM YYYY [à] HH[h]mm'),
                'date_heure_iso' => $rdv->date_heure->toIso8601String(),
                'medecin' => [
                    'id' => $rdv->medecin->id,
                    'nom' => 'Dr. ' . $rdv->medecin->user->name,
                    'specialite' => $rdv->medecin->specialite,
                ],
                'hopital' => $rdv->medecin->hopital ? [
                    'id' => $rdv->medecin->hopital->id,
                    'nom' => $rdv->medecin->hopital->nom,
                    'adresse' => $rdv->medecin->hopital->adresse,
                ] : null,
                'statut' => $rdv->statut,
                'statut_label' => match($rdv->statut) {
                    'confirme' => 'Confirmé',
                    'en_attente' => 'En attente',
                    default => 'Annulé'
                },
                'motif' => $rdv->motif,
            ]);

        return response()->json([
            'success' => true,
            'data' => $rendezVous
        ]);
    }

    // Récupère les notifications du patient
    public function notifications(): JsonResponse
    {
        $userId = Auth::id();

        // Récupérer les RDV à venir comme notifications
        $upcomingRdv = RendezVous::with('medecin.user')
            ->where('patient_id', $userId)
            ->where('date_heure', '>=', now())
            ->orderBy('date_heure')
            ->take(10)
            ->get()
            ->map(fn($rdv) => [
                'id' => $rdv->id,
                'title' => 'Rendez-vous avec Dr. ' . $rdv->medecin->user->name,
                'message' => $rdv->date_heure->isoFormat('ddd D MMM YYYY [à] HH[h]mm'),
                'time' => $rdv->date_heure->diffForHumans(),
                'type' => 'rdv',
                'read' => false,
            ]);

        return response()->json([
            'success' => true,
            'data' => $upcomingRdv
        ]);
    }

    // Marque une notification comme lue
    public function markNotificationAsRead(int $id): JsonResponse
    {
        // Ici on pourrait avoir une table notifications
        // Pour l'instant, on retourne juste un succès
        return response()->json([
            'success' => true,
            'message' => 'Notification marquée comme lue'
        ]);
    }
}