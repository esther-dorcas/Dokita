<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use App\Models\Hopital;

class HopitalSeeder extends Seeder
{
    public function run(): void
    {
        $hopitaux = [
            [
                'nom'         => 'Clinique Saint-Luc',
                'adresse'     => 'Akpakpa, Cotonou',
                'latitude'    => 6.3673,
                'longitude'   => 2.4272,
                'telephone'   => '+229 21 00 00 00',
                'whatsapp'    => '22921000000',
                'horaires'    => 'Lun-Ven 08h–18h · Sam 08h–13h',
                'description' => 'Clinique moderne spécialisée en cardiologie et pédiatrie.',
                'specialites' => [
                    ['nom_specialite'=>'Cardiologie',      'tarif'=>3500, 'icone'=>'❤️'],
                    ['nom_specialite'=>'Pédiatrie',        'tarif'=>2000, 'icone'=>'👶'],
                    ['nom_specialite'=>'Médecine Générale','tarif'=>1500, 'icone'=>'🩺'],
                    ['nom_specialite'=>'Stomatologie',     'tarif'=>4000, 'icone'=>'🦷'],
                ],
            ],
            [
                'nom'         => 'Centre Médical Fidjrossè',
                'adresse'     => 'Fidjrossè, Cotonou',
                'latitude'    => 6.3540,
                'longitude'   => 2.3980,
                'telephone'   => '+229 21 11 00 00',
                'whatsapp'    => '22921110000',
                'horaires'    => 'Lun-Sam 07h–19h',
                'description' => 'Centre médical spécialisé en pédiatrie et obstétrique.',
                'specialites' => [
                    ['nom_specialite'=>'Pédiatrie',   'tarif'=>2000, 'icone'=>'👶'],
                    ['nom_specialite'=>'Obstétrique', 'tarif'=>3000, 'icone'=>'🤱'],
                ],
            ],
            [
                'nom'         => 'Polyclinique Cadjèhoun',
                'adresse'     => 'Cadjèhoun, Cotonou',
                'latitude'    => 6.3730,
                'longitude'   => 2.3900,
                'telephone'   => '+229 21 22 00 00',
                'whatsapp'    => '22921220000',
                'horaires'    => 'Ouvert 24h/24 · Urgences disponibles',
                'description' => 'Polyclinique avec service d\'urgences 24h/24.',
                'specialites' => [
                    ['nom_specialite'=>'Médecine Générale','tarif'=>2500, 'icone'=>'🩺'],
                    ['nom_specialite'=>'Chirurgie',        'tarif'=>6000, 'icone'=>'🔪'],
                    ['nom_specialite'=>'Urgences',         'tarif'=>5000, 'icone'=>'🚨'],
                ],
            ],
            [
                'nom'         => 'Hôpital de Ménontin',
                'adresse'     => 'Ménontin, Cotonou',
                'latitude'    => 6.3800,
                'longitude'   => 2.4100,
                'telephone'   => '+229 21 33 00 00',
                'whatsapp'    => '22921330000',
                'horaires'    => 'Lun-Ven 07h–17h',
                'description' => 'Hôpital public avec toutes spécialités.',
                'specialites' => [
                    ['nom_specialite'=>'Médecine Générale','tarif'=>800,  'icone'=>'🩺'],
                    ['nom_specialite'=>'Gynécologie',      'tarif'=>1500, 'icone'=>'👩‍⚕️'],
                    ['nom_specialite'=>'Ophtalmologie',    'tarif'=>2000, 'icone'=>'👁️'],
                ],
            ],
        ];

        foreach ($hopitaux as $data) {
            $specs = $data['specialites'];
            unset($data['specialites']);
            $h = Hopital::create($data);
            foreach ($specs as $s) {
                $h->specialites()->create($s);
            }
        }
    }
}