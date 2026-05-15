<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Hopital;
use App\Models\User;
use App\Models\Medecin;
use App\Models\Specialite;

class AssignMedecinSeeder extends Seeder
{
    public function run()
    {
        $hopitaux = Hopital::all();
        $specialite = Specialite::first() ?? Specialite::create(['nom_specialite' => 'Médecine Générale']);
        
        foreach($hopitaux as $h) {
            if ($h->medecins()->count() == 0) {
                $u = User::factory()->create([
                    'name' => 'Dr. ' . fake()->lastName(),
                    'email' => 'doc'.$h->id.'@dokita.bj',
                    'role' => 'medecin',
                    'telephone' => '+229 90 00 00 2'.$h->id
                ]);
                
                Medecin::create([
                    'user_id' => $u->id,
                    'hopital_id' => $h->id,
                    'specialite_id' => $specialite->id,
                    'specialite' => $specialite->nom_specialite,
                    'bio' => 'Médecin généraliste affecté à '.$h->nom,
                    'disponibilites' => json_encode([
                        'lundi' => ['08:00-18:00'],
                        'mardi' => ['08:00-18:00'],
                        'mercredi' => ['08:00-18:00'],
                        'jeudi' => ['08:00-18:00'],
                        'vendredi' => ['08:00-18:00']
                    ]),
                    'statut' => 'actif'
                ]);
            }
        }
    }
}
