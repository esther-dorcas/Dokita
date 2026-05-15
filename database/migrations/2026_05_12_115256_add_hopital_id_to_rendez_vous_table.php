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
        Schema::table('rendez_vous', function (Blueprint $table) {
            $table->unsignedBigInteger('hopital_id')->nullable()->after('medecin_id');
            $table->foreign('hopital_id')->references('id')->on('hopitaux')->onDelete('set null');
        });

        // Backfill: derive hopital_id from medecin for existing rows
        \Illuminate\Support\Facades\DB::statement('
            UPDATE rendez_vous
            SET hopital_id = (SELECT hopital_id FROM medecins WHERE medecins.id = rendez_vous.medecin_id)
            WHERE hopital_id IS NULL
        ');
    }

    public function down(): void
    {
        Schema::table('rendez_vous', function (Blueprint $table) {
            $table->dropForeign(['hopital_id']);
            $table->dropColumn('hopital_id');
        });
    }
};
