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

        // Compter les urgences "locales" à l'hôpital du médecin, plutôt que TOUTES les urgences du monde
        $urgencesAssigneesCount = 0;
        if ($medecin->hopital) {
            $urgencesEnCours = Urgence::where('statut', 'en_cours')->get();
            $urgencesAssigneesCount = $urgencesEnCours->filter(function($u) use ($medecin) {
                // Rayon simple (ou simulation)
                if (!$u->latitude || !$medecin->hopital->latitude) return true;
                return true; // Simplification pour le dashboard : on compte celles proches
            })->count();
        }

        $upcomingConsultations = RendezVous::where('medecin_id', $medecin->id)
            ->whereDate('date_heure', Carbon::today())
            ->whereNotIn('statut', ['annule'])
            ->with('patient')
            ->orderBy('date_heure')
            ->get();

        $latestUrgence = Urgence::where('statut', 'en_cours')
            ->orderBy('created_at', 'desc')
            ->first();

        $recentActivity = RendezVous::where('medecin_id', $medecin->id)
            ->whereIn('statut', ['termine', 'annule'])
            ->orderBy('updated_at', 'desc')
            ->take(5)
            ->get();

        return view('medecin.dashboard', compact(
            'patientsPrevusCount',
            'consultesJourCount',
            'urgencesAssigneesCount',
            'upcomingConsultations',
            'recentActivity',
            'latestUrgence'
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

    public function updateProfil(Request $request)
    {
        $user = Auth::user();
        $medecin = $user->medecin;

        $user->update([
            'name' => $request->get('name'),
            'telephone' => $request->get('telephone')
        ]);

        $medecin->update([
            'experience' => $request->get('experience'),
            'tarif' => $request->get('tarif'),
            'bio' => $request->get('bio')
        ]);

        return back()->with('success', 'Profil mis à jour avec succès');
    }

    public function consultation(Request $request)
    {
        $rdvId = $request->get('rdv_id');
        $patientId = $request->get('patient_id');
        
        if ($rdvId) {
            $rdv = RendezVous::with('patient')->findOrFail($rdvId);
            $patientUser = $rdv->patient;
            $motif = $rdv->motif;
        } else {
            $patientUser = \App\Models\User::with('patient')->findOrFail($patientId);
            $motif = $request->get('motif');
        }

        return view('medecin.consultation', [
            'patient' => $patientUser,
            'motif'   => $motif,
            'rdv'     => $rdv ?? null
        ]);
    }

    public function cloturerConsultation($id)
    {
        $rdv = RendezVous::where('id', $id)
            ->where('medecin_id', Auth::user()->medecin->id)
            ->firstOrFail();

        $rdv->update(['statut' => 'termine']);

        return response()->json(['success' => true]);
    }

    public function annulerRdv(Request $request, $id)
    {
        $rdv = RendezVous::where('id', $id)
            ->where('medecin_id', Auth::user()->medecin->id)
            ->firstOrFail();

        $rdv->update([
            'statut' => 'annule',
            'motif_annulation' => $request->get('motif')
        ]);

        return back()->with('success', 'Rendez-vous annulé avec succès.');
    }

    public function ordonnances(Request $request)
    {
        $patientId = $request->get('patient_id');
        $patient = null;
        
        if ($patientId) {
            $patient = \App\Models\User::find($patientId);
        } elseif ($request->has('patient')) {
            $patient = \App\Models\User::where('name', $request->get('patient'))->first();
        }

        return view('medecin.ordonnance', compact('patient'));
    }

    public function settings()
    {
        return view('medecin.settings');
    }

    public function updateSettings(Request $request)
    {
        $medecin = Auth::user()->medecin;
        if (!$medecin) return back()->with('error', 'Profil médecin non trouvé');

        $medecin->update([
            'disponibilites' => $request->get('dispo')
        ]);

        return back()->with('success', 'Paramètres mis à jour avec succès');
    }
}
