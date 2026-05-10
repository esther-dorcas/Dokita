<?php

namespace App\Console\Commands;

use App\Mail\RdvRappelMail;
use App\Models\RendezVous;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class EnvoyerRappelsRdv extends Command
{
    protected $signature   = 'rdv:rappels';
    protected $description = 'Envoie les rappels email 24h avant chaque rendez-vous';

    public function handle(): void
    {
        $demain = now()->addDay();

        $rdvs = RendezVous::with(['patient', 'medecin.user', 'medecin.hopital'])
            ->whereDate('date_heure', $demain->toDateString())
            ->where('statut', '!=', 'annule')
            ->where('rappel_envoye', false)
            ->get();

        foreach ($rdvs as $rdv) {
            if ($rdv->patient && $rdv->patient->email) {
                Mail::to($rdv->patient->email)->send(new RdvRappelMail($rdv));
                $rdv->update(['rappel_envoye' => true]);
                $this->info("Rappel envoyé à {$rdv->patient->email} pour le RDV #{$rdv->id}");
            }
        }

        $this->info("Terminé – {$rdvs->count()} rappel(s) traité(s).");
    }
}
