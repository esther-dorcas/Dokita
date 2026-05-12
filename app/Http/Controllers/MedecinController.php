<?php

namespace App\Http\Controllers;

use App\Models\RendezVous;
use App\Models\Urgence;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class MedecinController extends Controller
{
    public function dashboard()
    {
        $user = Auth::user();
        $medecin = $user->medecin;

        if (!$medecin) {
            $medecin = \App\Models\Medecin::create([
                'user_id' => $user->id,
                'specialite' => $user->specialty ?? 'Généraliste',
            ]);
        }

        // Stats
        $patientsPrevusCount = RendezVous::where('medecin_id', $medecin->id)
            ->whereDate('date_heure', Carbon::today())
            ->whereNotIn('statut', ['annule'])
            ->count();

        $consultesJourCount = RendezVous::where('medecin_id', $medecin->id)
            ->whereDate('date_heure', Carbon::today())
            ->where('statut', 'termine')
            ->count();

        $urgencesAssigneesCount = Urgence::where('statut', 'en_cours')->count(); // Logic for assignment could be refined

        $upcomingConsultations = RendezVous::where('medecin_id', $medecin->id)
            ->whereDate('date_heure', Carbon::today())
            ->whereNotIn('statut', ['annule'])
            ->with('patient')
            ->orderBy('date_heure')
            ->get();

        return view('medecin.dashboard', compact(
            'patientsPrevusCount',
            'consultesJourCount',
            'urgencesAssigneesCount',
            'upcomingConsultations'
        ));
    }

    public function rdv()
    {
        $user = Auth::user();
        $medecin = $user->medecin;

        if (!$medecin) {
            return redirect()->route('home')->with('error', 'Profil médecin non trouvé.');
        }

        $appointments = RendezVous::where('medecin_id', $medecin->id)
            ->with('patient')
            ->orderBy('date_heure', 'desc')
            ->get();

        return view('medecin.rdv', compact('appointments'));
    }

    public function planning()
    {
        return view('medecin.planning');
    }

    public function profil()
    {
        return view('medecin.profil');
    }

    public function consultation(Request $request)
    {
        $name = $request->get('name');
        $motif = $request->get('motif');
        return view('medecin.consultation', compact('name', 'motif'));
    }

    public function settings()
    {
        return view('medecin.settings');
    }
}
