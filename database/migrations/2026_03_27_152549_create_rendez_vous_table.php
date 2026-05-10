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
    Schema::create('rendez_vous', function (Blueprint $table) {
        $table->id();
        $table->foreignId('patient_id')->constrained('users')->onDelete('cascade');
        $table->foreignId('medecin_id')->constrained('medecins')->onDelete('cascade');
        $table->dateTime('date_heure');
        $table->string('motif')->nullable();
        $table->enum('statut', ['en_attente','confirme','annule','reporte'])->default('en_attente');
        $table->boolean('rappel_envoye')->default(false);
        $table->enum('paiement_mode', ['sur_place','mtn','moov'])->default('sur_place');
        $table->enum('paiement_statut', ['non_paye','en_attente','paye'])->default('non_paye');
        $table->string('paiement_ref')->nullable();
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rendez_vous');
    }
};
