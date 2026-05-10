<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$user = App\Models\User::find(1);
$hopitaux = App\Models\Hopital::all();

// Créer des médecins pour le premier hôpital
foreach ($hopitaux->take(3) as $hopital) {
    $medecin = App\Models\Medecin::create([
        'user_id' => $user->id,
        'hopital_id' => $hopital->id,
        'specialite' => 'Médecine Générale',
        'bio' => 'Médecin expérimenté',
        'disponibilites' => [],
        'statut' => 'actif',
    ]);
    
    // Créer 3 rendez-vous pour ce médecin (dont certains futurs)
    for ($i = 0; $i < 3; $i++) {
        App\Models\RendezVous::create([
            'patient_id' => 2,
            'medecin_id' => $medecin->id,
            'date_heure' => now()->addDays(rand(1, 30))->setHour(rand(8, 17))->setMinute(0),
            'motif' => 'Consultation générale',
            'statut' => rand(0, 1) ? 'confirme' : 'en_attente',
            'rappel_envoye' => false,
            'paiement_mode' => 'sur_place',
            'paiement_statut' => 'en_attente'
        ]);
    }
}

echo 'Données de test créées avec succès!';
