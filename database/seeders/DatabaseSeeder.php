<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Créer un admin
        User::factory()->create([
            'name' => 'Admin Dokita',
            'email' => 'admin@dokita.bj',
            'role' => 'admin',
        ]);

        // Créer des patients
        User::factory()->create([
            'name' => 'Jean Dupont',
            'email' => 'patient1@example.com',
            'telephone' => '+229 97 00 00 01',
            'role' => 'patient',
        ]);

        User::factory()->create([
            'name' => 'Marie Martin',
            'email' => 'patient2@example.com',
            'telephone' => '+229 97 00 00 02',
            'role' => 'patient',
        ]);

        // Créer des médecins
        $medecin1 = User::factory()->create([
            'name' => 'Dr. Alain Koffi',
            'email' => 'medecin1@example.com',
            'telephone' => '+229 97 00 00 11',
            'role' => 'medecin',
        ]);

        $medecin2 = User::factory()->create([
            'name' => 'Dr. Sophie Akpovi',
            'email' => 'medecin2@example.com',
            'telephone' => '+229 97 00 00 12',
            'role' => 'medecin',
        ]);

        // Créer des hôpitaux
        $this->call(HopitalSeeder::class);

        // Associer médecins aux hôpitaux
        $hopital1 = \App\Models\Hopital::first();
        $hopital2 = \App\Models\Hopital::skip(1)->first();

        \App\Models\Medecin::create([
            'user_id' => $medecin1->id,
            'hopital_id' => $hopital1->id,
            'specialite_id' => 1,
            'specialite' => 'Cardiologie',
            'bio' => 'Médecin cardiologue expérimenté avec 15 ans de pratique.',
            'disponibilites' => json_encode([
                'lundi' => ['08:00-12:00', '14:00-18:00'],
                'mardi' => ['08:00-12:00', '14:00-18:00'],
                'mercredi' => ['08:00-12:00'],
                'jeudi' => ['08:00-12:00', '14:00-18:00'],
                'vendredi' => ['08:00-12:00', '14:00-18:00'],
            ]),
            'statut' => 'actif',
        ]);

        \App\Models\Medecin::create([
            'user_id' => $medecin2->id,
            'hopital_id' => $hopital2->id,
            'specialite_id' => 2,
            'specialite' => 'Pédiatrie',
            'bio' => 'Pédiatre spécialisée dans les soins des nouveau-nés et enfants.',
            'disponibilites' => json_encode([
                'lundi' => ['09:00-13:00', '15:00-17:00'],
                'mardi' => ['09:00-13:00', '15:00-17:00'],
                'mercredi' => ['09:00-13:00'],
                'jeudi' => ['09:00-13:00', '15:00-17:00'],
                'vendredi' => ['09:00-13:00', '15:00-17:00'],
            ]),
            'statut' => 'actif',
        ]);
    }
}
