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
    Schema::create('specialites', function (Blueprint $table) {
        $table->id();
        $table->foreignId('hopital_id')->constrained('hopitaux')->onDelete('cascade');
        $table->string('nom_specialite');
        $table->decimal('tarif', 10, 2)->default(0);
        $table->string('icone')->default('🩺');
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('specialities');
    }
};
