<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $hopitaux = \Illuminate\Support\Facades\DB::table('hopitaux')
            ->whereNull('user_id')
            ->get();

        foreach ($hopitaux as $hopital) {
            $slug  = \Illuminate\Support\Str::slug($hopital->nom);
            $email = $slug . '@dokita.bj';

            // Évite les doublons d'email
            $existing = \Illuminate\Support\Facades\DB::table('users')->where('email', $email)->first();
            if ($existing) {
                \Illuminate\Support\Facades\DB::table('hopitaux')
                    ->where('id', $hopital->id)
                    ->update(['user_id' => $existing->id]);
                continue;
            }

            $userId = \Illuminate\Support\Facades\DB::table('users')->insertGetId([
                'name'       => $hopital->nom,
                'email'      => $email,
                'password'   => \Illuminate\Support\Facades\Hash::make('Dokita2026!'),
                'role'       => 'hopital',
                'telephone'  => $hopital->telephone ?? '',
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            \Illuminate\Support\Facades\DB::table('hopitaux')
                ->where('id', $hopital->id)
                ->update(['user_id' => $userId]);
        }
    }

    public function down(): void
    {
        // Les comptes créés automatiquement ne sont pas supprimés en rollback
        // pour éviter de perdre des données réelles.
    }
};
