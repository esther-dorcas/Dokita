<?php

namespace App\Http\Controllers;

use App\Models\Hopital;
use App\Models\RendezVous;
use App\Models\Urgence;
use App\Models\User;
use App\Mail\RdvStatusMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;

class HopitalDashboardController extends Controller
{
    /**
     * Calcul de distance en kilomètres (Formule de Haversine)
     */
    private function calculateDistance($lat1, $lon1, $lat2, $lon2)
    {
        if (!$lat1 || !$lon1 || !$lat2 || !$lon2) return 0; // Si pas de GPS, on considère "proche" par défaut
        $earthRadius = 6371; // km
        $dLat = deg2rad($lat2 - $lat1);
        $dLon = deg2rad($lon2 - $lon1);
        $a = sin($dLat/2) * sin($dLat/2) + cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * sin($dLon/2) * sin($dLon/2);
        $c = 2 * asin(sqrt($a));
        return $earthRadius * $c;
    }

    public function index()
    {
        $user = Auth::user();
        $hopital = $user->hopital;

        if (!$hopital) {
            $hopital = \App\Models\Hopital::create([
                'user_id'   => $user->id,
                'nom'       => $user->name,
                'adresse'   => '',
                'telephone' => $user->telephone ?? '',
            ]);
        }

        // Statistics
        $medecinsActifsCount = \App\Models\User::where('role', 'medecin')
            ->whereHas('medecin', fn($q) => $q->where('hopital_id', $hopital->id))
            ->count();
        
        $consultationsTodayCount = \App\Models\RendezVous::whereHas('medecin', fn($q) => $q->where('hopital_id', $hopital->id))
            ->whereDate('date_heure', Carbon::today())
            ->count();

        $allUrgencesEnCours = \App\Models\Urgence::where('statut', 'en_cours')->get();
        $urgencesEnCoursCount = $allUrgencesEnCours->filter(function($u) use ($hopital) {
            $dist = $this->calculateDistance($hopital->latitude, $hopital->longitude, $u->latitude, $u->longitude);
            return $dist <= 15; // Rayon de 15km
        })->count();
        $litsDisponibles = 18; // Placeholder as in view

        // Recent activity
        $recentDemandes = \App\Models\RendezVous::whereHas('medecin', fn($q) => $q->where('hopital_id', $hopital->id))
            ->with('patient', 'medecin.user')
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        $medecinsGarde = \App\Models\User::where('role', 'medecin')
            ->whereHas('medecin', fn($q) => $q->where('hopital_id', $hopital->id))
            ->with('medecin.specialite')
            ->take(4)
            ->get();

        return view('hopital.dashboard', compact(
            'medecinsActifsCount', 
            'consultationsTodayCount', 
            'urgencesEnCoursCount', 
            'litsDisponibles',
            'recentDemandes',
            'medecinsGarde'
        ));
    }

    public function rdv()
    {
        $hopital = Auth::user()->hopital;

        $now        = Carbon::now();
        $todayStart = $now->copy()->startOfDay();
        $todayEnd   = $now->copy()->endOfDay();

        // Filtre strictement sur l'hôpital connecté
        $allRdvs = RendezVous::with('patient', 'medecin.user')
            ->where('hopital_id', $hopital->id)
            ->orderBy('date_heure', 'desc')
            ->get();

        // RDV en attente de validation (à confirmer en priorité)
        $rdvEnAttente = $allRdvs->where('statut', 'en_attente');

        $rdvAujourdhui = $allRdvs->filter(fn($r) =>
            $r->date_heure && $r->date_heure->between($todayStart, $todayEnd)
        );

        $rdvAVenir = $allRdvs->filter(fn($r) =>
            $r->date_heure && $r->date_heure->gt($todayEnd) && $r->statut !== 'annule'
        );

        $rdvHistorique = $allRdvs->filter(fn($r) =>
            ($r->date_heure && $r->date_heure->lt($todayStart)) || !$r->date_heure
        );

        return view('hopital.rdv', compact('allRdvs', 'rdvEnAttente', 'rdvAujourdhui', 'rdvAVenir', 'rdvHistorique'));
    }

    public function updateRdvStatut(Request $request, $id)
    {
        $rdv = RendezVous::with(['patient', 'medecin.user'])->findOrFail($id);
        $rdv->update(['statut' => $request->statut]);
        
        // ==========================================
        // NOTIFICATION PAR MAIL (PATIENT ET MÉDECIN)
        // ==========================================
        // Mail au Patient
        if ($rdv->patient && $rdv->patient->email) {
            Mail::to($rdv->patient->email)->send(new RdvStatusMail($rdv, $request->statut));
        }
        
        // Mail au Médecin
        if ($rdv->medecin && $rdv->medecin->user && $rdv->medecin->user->email) {
            Mail::to($rdv->medecin->user->email)->send(new RdvStatusMail($rdv, $request->statut, 'medecin'));
        }

        // ==========================================
        // NOTIFICATION PAR APPEL (SIMULATION)
        // ==========================================
        if ($request->statut === 'confirme') {
            if ($rdv->patient && $rdv->patient->telephone) {
                \Illuminate\Support\Facades\Log::info("📞 [SIMULATION APPEL VOCAL] -> Appelle le PATIENT ({$rdv->patient->telephone}). Message : 'Votre rendez-vous du {$rdv->date_heure->format('d/m/Y')} est confirmé.'");
            }
            if ($rdv->medecin && $rdv->medecin->user && $rdv->medecin->user->telephone) {
                \Illuminate\Support\Facades\Log::info("📞 [SIMULATION APPEL VOCAL] -> Appelle le MÉDECIN ({$rdv->medecin->user->telephone}). Message : 'Nouveau rendez-vous confirmé avec {$rdv->patient->name} le {$rdv->date_heure->format('d/m/Y')}.'");
            }
        }

        return back()->with('success', 'Le statut du rendez-vous a été mis à jour. Les notifications ont été envoyées.');
    }

    public function reprogrammerRdv(Request $request, $id)
    {
        $rdv = RendezVous::with(['patient', 'medecin.user'])->findOrFail($id);
        $rdv->update(['date_heure' => $request->date_heure]);

        // ==========================================
        // 1. NOTIFICATION PAR MAIL
        // ==========================================
        // Mail au Patient
        if ($rdv->patient && $rdv->patient->email) {
            Mail::to($rdv->patient->email)->send(new RdvStatusMail($rdv, 'reprogramme'));
        }
        // Mail au Médecin
        if ($rdv->medecin && $rdv->medecin->user && $rdv->medecin->user->email) {
            Mail::to($rdv->medecin->user->email)->send(new RdvStatusMail($rdv, 'reprogramme', 'medecin'));
        }

        // ==========================================
        // 2. NOTIFICATION PAR APPEL (SIMULATION)
        // ==========================================
        // Appel au Patient
        if ($rdv->patient && $rdv->patient->telephone) {
            \Illuminate\Support\Facades\Log::info("📞 [SIMULATION APPEL VOCAL - TWILIO] -> Appelle le PATIENT ({$rdv->patient->telephone}). Message vocal : 'Bonjour {$rdv->patient->name}, votre hôpital a reprogrammé votre rendez-vous au {$rdv->date_heure->format('d/m/Y à H:i')}.'");
        }
        // Appel au Médecin
        if ($rdv->medecin && $rdv->medecin->user && $rdv->medecin->user->telephone) {
            \Illuminate\Support\Facades\Log::info("📞 [SIMULATION APPEL VOCAL - TWILIO] -> Appelle le MÉDECIN ({$rdv->medecin->user->telephone}). Message vocal : 'Bonjour Dr. {$rdv->medecin->user->name}, votre consultation avec {$rdv->patient->name} a été déplacée au {$rdv->date_heure->format('d/m/Y à H:i')}.'");
        }

        return back()->with('success', 'Le rendez-vous a été reprogrammé. Le patient et le médecin ont été informés par Mail et Appel.');
    }

    public function medecins()
    {
        $hopital = Auth::user()->hopital;
        $medecins = User::where('role', 'medecin')
            ->whereHas('medecin', function($q) use ($hopital) {
                $q->where('hopital_id', $hopital->id);
            })
            ->with(['medecin.specialite', 'medecin.rendezVous'])
            ->get();
        return view('hopital.medecins', compact('medecins'));
    }

    public function medecinsCreate()
    {
        return view('hopital.medecins-create');
    }

    public function medecinsEdit($id)
    {
        $medecinUser = User::where('role', 'medecin')->findOrFail($id);
        return view('hopital.medecins-edit', compact('medecinUser'));
    }

    public function urgences()
    {
        $hopital = Auth::user()->hopital;
        $toutesUrgences = Urgence::with('patient')->latest()->get();
        
        // Filtre : uniquement les urgences à moins de 15km (ou celles sans GPS)
        $urgences = $toutesUrgences->filter(function($u) use ($hopital) {
            $dist = $this->calculateDistance($hopital->latitude, $hopital->longitude, $u->latitude, $u->longitude);
            return $dist <= 15;
        })->values();

        return view('hopital.urgences', compact('urgences'));
    }

    public function parametres()
    {
        return view('hopital.parametres');
    }

    public function countUrgences()
    {
        $hopital = Auth::user()->hopital;
        $all = Urgence::where('statut', 'en_cours')->get();
        $count = $all->filter(function($u) use ($hopital) {
            $dist = $this->calculateDistance($hopital->latitude, $hopital->longitude, $u->latitude, $u->longitude);
            return $dist <= 15;
        })->count();
        
        return response()->json($count);
    }

    public function resolveUrgence($id)
    {
        Urgence::where('id', $id)->update(['statut' => 'resolu']);
        return response()->json(['success' => true]);
    }
}
