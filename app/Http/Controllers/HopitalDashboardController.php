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
    public function index()
    {
        $user = Auth::user();
        $hopital = $user->hopital;

        if (!$hopital) {
            $hopital = \App\Models\Hopital::create([
                'user_id' => $user->id,
                'nom' => $user->name,
                'telephone' => $user->telephone,
            ]);
        }

        // Statistics
        $medecinsActifsCount = \App\Models\User::where('role', 'medecin')
            ->whereHas('medecin', fn($q) => $q->where('hopital_id', $hopital->id))
            ->count();
        
        $consultationsTodayCount = \App\Models\RendezVous::whereHas('medecin', fn($q) => $q->where('hopital_id', $hopital->id))
            ->whereDate('date_heure', Carbon::today())
            ->count();

        $urgencesEnCoursCount = \App\Models\Urgence::where('statut', 'en_cours')->count();
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
        $now = Carbon::now();
        $todayStart = $now->copy()->startOfDay();
        $todayEnd = $now->copy()->endOfDay();

        $allRdvs = RendezVous::with('patient', 'medecin.user')->orderBy('date_heure', 'desc')->get();
        
        $rdvAujourdhui = $allRdvs->filter(function($rdv) use ($todayStart, $todayEnd) {
            return $rdv->date_heure && $rdv->date_heure->between($todayStart, $todayEnd);
        });

        $rdvAVenir = $allRdvs->filter(function($rdv) use ($todayEnd) {
            return $rdv->date_heure && $rdv->date_heure->gt($todayEnd);
        });

        $rdvHistorique = $allRdvs->filter(function($rdv) use ($todayStart) {
            return $rdv->date_heure && $rdv->date_heure->lt($todayStart) || !$rdv->date_heure;
        });

        return view('hopital.rdv', compact('allRdvs', 'rdvAujourdhui', 'rdvAVenir', 'rdvHistorique'));
    }

    public function updateRdvStatut(Request $request, $id)
    {
        $rdv = RendezVous::with('patient')->findOrFail($id);
        $rdv->update(['statut' => $request->statut]);
        
        if ($rdv->patient && $rdv->patient->email) {
            Mail::to($rdv->patient->email)->send(new RdvStatusMail($rdv, $request->statut));
        }

        return back()->with('success', 'Le statut du rendez-vous a été mis à jour.');
    }

    public function reprogrammerRdv(Request $request, $id)
    {
        $rdv = RendezVous::with('patient')->findOrFail($id);
        $rdv->update(['date_heure' => $request->date_heure]);

        if ($rdv->patient && $rdv->patient->email) {
            Mail::to($rdv->patient->email)->send(new RdvStatusMail($rdv, 'reprogramme'));
        }

        return back()->with('success', 'Le rendez-vous a été reprogrammé avec succès.');
    }

    public function medecins()
    {
        $medecins = User::where('role', 'medecin')->with('medecin.specialite')->get();
        return view('hopital.medecins', compact('medecins'));
    }

    public function medecinsCreate()
    {
        return view('hopital.medecins-create');
    }

    public function urgences()
    {
        $urgences = Urgence::with('patient')->latest()->get();
        return view('hopital.urgences', compact('urgences'));
    }

    public function parametres()
    {
        return view('hopital.parametres');
    }

    public function countUrgences()
    {
        return response()->json(Urgence::where('statut', 'en_cours')->count());
    }

    public function resolveUrgence($id)
    {
        Urgence::where('id', $id)->update(['statut' => 'resolu']);
        return response()->json(['success' => true]);
    }
}
