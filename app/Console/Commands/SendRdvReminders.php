<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class SendRdvReminders extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'rdv:send-reminders';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Envoyer les rappels de rendez-vous 24h avant';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $demain = now()->addDay();

        $rdvDemain = \App\Models\RendezVous::with(['patient', 'medecin.user', 'medecin.hopital'])
            ->whereDate('date_heure', $demain->toDateString())
            ->whereIn('statut', ['en_attente', 'confirme'])
            ->where('rappel_envoye', false)
            ->get();

        $this->info("Trouvé {$rdvDemain->count()} rendez-vous pour demain");

        foreach ($rdvDemain as $rdv) {
            if ($rdv->patient->email) {
                \Illuminate\Support\Facades\Mail::to($rdv->patient->email)->send(new \App\Mail\RdvRappelMail($rdv));
                $rdv->update(['rappel_envoye' => true]);
                $this->info("Rappel envoyé à {$rdv->patient->email}");
            }
        }

        $this->info('Rappels envoyés avec succès');
    }
}
