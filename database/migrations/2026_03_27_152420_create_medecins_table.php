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
    Schema::create('medecins', function (Blueprint $table) {
        $table->id();
        $table->foreignId('user_id')->constrained()->onDelete('cascade');
        $table->foreignId('hopital_id')->constrained('hopitaux')->onDelete('cascade');
        $table->foreignId('specialite_id')->nullable()->constrained('specialites')->nullOnDelete();
        $table->string('specialite');
        $table->text('bio')->nullable();
        $table->json('disponibilites')->nullable();
        $table->enum('statut', ['actif','inactif','en_attente'])->default('actif');
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('medecins');
    }
};
