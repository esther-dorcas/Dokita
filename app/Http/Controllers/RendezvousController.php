<?php

namespace App\Http\Controllers;

use App\Mail\RdvAnnulationMail;
use App\Mail\RdvConfirmationMail;
use App\Models\Medecin;
use App\Models\RendezVous;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class RendezvousController extends Controller
{
    public function index()
    {
        $rendezVous = RendezVous::with(['medecin.user', 'medecin.hopital'])
            ->where('patient_id', Auth::id())
            ->orderBy('date_heure')
            ->get();

        return view('rdv.index', compact('rendezVous'));
    }

    public function create()
    {
        $medecins = Medecin::with(['user', 'hopital'])
            ->where('statut', 'actif')
            ->whereHas('user', function($query) {
                $query->where('role', 'medecin');
            })
            ->get();

        return view('rdv.create', compact('medecins'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'medecin_id' => ['required', 'exists:medecins,id'],
            'date'       => ['required', 'date'],
            'heure'      => ['required', 'regex:/^([01]?[0-9]|2[0-3]):[0-5][0-9]$/'],
            'motif'      => ['nullable', 'string', 'max:255'],
        ]);

        $medecin = Medecin::findOrFail($request->medecin_id);
        $dateHeure = Carbon::parse($request->date . ' ' . $request->heure);

        $exists = RendezVous::where('medecin_id', $medecin->id)
            ->where('date_heure', $dateHeure)
            ->where('statut', '!=', 'annule')
            ->exists();

        if ($exists) {
            return back()->with('error', 'Ce créneau est déjà réservé. Veuillez en choisir un autre.');
        }

        // --- NOUVELLE LIMITE : Max 2 RDV par jour dans une même clinique ---
        $rdvsCountToday = RendezVous::where('patient_id', Auth::id())
            ->where('hopital_id', $medecin->hopital_id)
            ->whereDate('date_heure', $dateHeure->toDateString())
            ->where('statut', '!=', 'annule')
            ->count();

        if ($rdvsCountToday >= 2) {
            return back()->with('error', 'Vous avez atteint la limite maximale de 2 rendez-vous par jour pour cette clinique.');
        }

        $rdv = RendezVous::create([
            'patient_id'      => Auth::id(),
            'medecin_id'      => $medecin->id,
            'hopital_id'      => $medecin->hopital_id,
            'date_heure'      => $dateHeure,
            'motif'           => $request->motif ?? 'Consultation médicale',
            'statut'          => 'en_attente',
            'rappel_envoye'   => false,
            'paiement_mode'   => 'sur_place',
            'paiement_statut' => 'non_paye',
        ]);

        $patient = Auth::user();
        if ($patient->email) {
            Mail::to($patient->email)->send(new RdvConfirmationMail($rdv->load(['medecin.user', 'medecin.hopital'])));
        }

        // --- NOTIFICATION À L'HÔPITAL ---
        $hopitalUser = $medecin->hopital->user;
        if ($hopitalUser && $hopitalUser->email) {
            Mail::to($hopitalUser->email)->send(new \App\Mail\NewRdvRequestMail($rdv));
        }

        return back()->with('success', 'Votre rendez-vous a bien été pris en compte. Un email de confirmation vous a été envoyé.');
    }

    public function annuler($id)
    {
        $rdv = RendezVous::with(['medecin.user', 'medecin.hopital'])
            ->where('id', $id)
            ->where('patient_id', Auth::id())
            ->firstOrFail();

        $rdv->update(['statut' => 'annule']);

        $patient = Auth::user();
        if ($patient->email) {
            Mail::to($patient->email)->send(new RdvAnnulationMail($rdv));
        }

        return back()->with('success', 'Votre rendez-vous a été annulé.');
    }
}
