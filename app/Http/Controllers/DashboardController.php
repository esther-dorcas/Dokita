<?php

namespace App\Http\Controllers;

use App\Models\RendezVous;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function patient()
    {
        $userId = Auth::id();
        
        \Log::info('Dashboard patient - userId: ' . $userId);

        $upcomingRendezVous = RendezVous::with('medecin.hopital', 'medecin.user')
            ->where('patient_id', $userId)
            ->where('date_heure', '>=', now())
            ->orderBy('date_heure')
            ->take(4)
            ->get();

        $upcomingCount = RendezVous::where('patient_id', $userId)
            ->where('date_heure', '>=', now())
            ->count();

        $completedCount = RendezVous::where('patient_id', $userId)
            ->where('date_heure', '<', now())
            ->count();

        $confirmedCount = RendezVous::where('patient_id', $userId)
            ->where('statut', 'confirme')
            ->count();

        $recentHopitaux = RendezVous::with('medecin.hopital')
            ->where('patient_id', $userId)
            ->latest('date_heure')
            ->get()
            ->map(fn($rdv) => $rdv->medecin->hopital)
            ->filter()
            ->unique('id')
            ->take(3);

        $notifications = $upcomingRendezVous->map(fn($rdv) => [
            'title' => 'Rendez-vous à venir',
            'message' => 'Demain à '.$rdv->date_heure->format('H:i').' avec Dr. '.$rdv->medecin->user->name,
            'time' => $rdv->date_heure->diffForHumans(),
        ])->toArray();

        \Log::info('Dashboard - upcomingCount: ' . $upcomingCount);

        return view('patient.dashboard', [
            'upcomingRendezVous' => $upcomingRendezVous,
            'upcomingCount' => $upcomingCount,
            'completedCount' => $completedCount,
            'confirmedCount' => $confirmedCount,
            'recentHopitaux' => $recentHopitaux,
            'notifications' => $notifications
        ]);
    }
}
