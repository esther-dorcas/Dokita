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
        Schema::create('notifications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('rdv_id')->constrained('rendez_vous')->onDelete('cascade');
            $table->enum('type', ['email', 'sms']);
            $table->enum('statut', ['envoye', 'echoue', 'en_attente'])->default('en_attente');
            $table->dateTime('date_envoi')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notifications');
    }
};
