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
        $user    = Auth::user();
        $medecin = $user->medecin;

        if (!$medecin) {
            return redirect()->route('home')->with('error', 'Profil médecin non trouvé.');
        }

        // Le médecin ne voit QUE les RDV confirmés par l'hôpital
        $appointments = RendezVous::where('medecin_id', $medecin->id)
            ->whereIn('statut', ['confirme', 'reporte', 'termine'])
            ->with('patient', 'hopital')
            ->orderBy('date_heure', 'asc')
            ->get();

        // Compte des RDV en attente (info uniquement, pas encore visibles)
        $enAttenteCount = RendezVous::where('medecin_id', $medecin->id)
            ->where('statut', 'en_attente')
            ->count();

        return view('medecin.rdv', compact('appointments', 'enAttenteCount'));
    }

    public function planning()
    {
        $user = Auth::user();
        $medecin = $user->medecin;

        if (!$medecin) {
            return redirect()->route('home')->with('error', 'Profil médecin non trouvé.');
        }

        $rendezVous = RendezVous::where('medecin_id', $medecin->id)
            ->whereNotIn('statut', ['annule'])
            ->with('patient')
            ->get();

        $events = $rendezVous->map(function ($rdv) {
            $isPast = Carbon::parse($rdv->date_heure)->isPast();
            $patientName = $rdv->patient->name ?? 'Patient';
            
            return [
                'title' => $patientName . ($isPast ? ' (Terminé)' : ''),
                'start' => Carbon::parse($rdv->date_heure)->format('Y-m-d\TH:i:s'),
                'end' => Carbon::parse($rdv->date_heure)->addMinutes(30)->format('Y-m-d\TH:i:s'),
                'extendedProps' => [
                    'isPast' => $isPast,
                    'isUrgent' => str_contains(strtolower($rdv->motif ?? ''), 'urgence')
                ]
            ];
        });

        return view('medecin.planning', ['eventsJson' => $events->toJson()]);
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
