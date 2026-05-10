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

        $rdv = RendezVous::create([
            'patient_id'      => Auth::id(),
            'medecin_id'      => $medecin->id,
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
