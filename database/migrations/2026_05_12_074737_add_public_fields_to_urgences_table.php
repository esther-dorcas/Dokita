<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // SQLite ne supporte pas ALTER COLUMN — on recrée la table
        DB::statement('PRAGMA foreign_keys = OFF');

        DB::statement('CREATE TABLE urgences_new (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            patient_id INTEGER NULL REFERENCES users(id) ON DELETE SET NULL,
            nom_appelant VARCHAR(255) NULL,
            telephone VARCHAR(255) NULL,
            description TEXT NOT NULL,
            localisation VARCHAR(255) NULL,
            latitude DECIMAL(10,7) NULL,
            longitude DECIMAL(10,7) NULL,
            statut VARCHAR(255) NOT NULL DEFAULT "en_cours",
            created_at TIMESTAMP NULL,
            updated_at TIMESTAMP NULL
        )');

        DB::statement('INSERT INTO urgences_new
            (id, patient_id, description, localisation, latitude, longitude, statut, created_at, updated_at)
            SELECT id, patient_id, description, localisation, latitude, longitude, statut, created_at, updated_at
            FROM urgences');

        DB::statement('DROP TABLE urgences');
        DB::statement('ALTER TABLE urgences_new RENAME TO urgences');

        DB::statement('PRAGMA foreign_keys = ON');
    }

    public function down(): void
    {
        DB::statement('PRAGMA foreign_keys = OFF');

        DB::statement('CREATE TABLE urgences_old (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            patient_id INTEGER NOT NULL REFERENCES users(id) ON DELETE CASCADE,
            description TEXT NOT NULL,
            localisation VARCHAR(255) NULL,
            latitude DECIMAL(10,7) NULL,
            longitude DECIMAL(10,7) NULL,
            statut VARCHAR(255) NOT NULL DEFAULT "en_cours",
            created_at TIMESTAMP NULL,
            updated_at TIMESTAMP NULL
        )');

        DB::statement('INSERT INTO urgences_old
            (id, patient_id, description, localisation, latitude, longitude, statut, created_at, updated_at)
            SELECT id, patient_id, description, localisation, latitude, longitude, statut, created_at, updated_at
            FROM urgences WHERE patient_id IS NOT NULL');

        DB::statement('DROP TABLE urgences');
        DB::statement('ALTER TABLE urgences_old RENAME TO urgences');

        DB::statement('PRAGMA foreign_keys = ON');
    }
};
