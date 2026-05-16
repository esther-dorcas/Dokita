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
        Schema::table('medecins', function (Blueprint $table) {
            $table->integer('experience')->default(1)->after('specialite');
            $table->integer('tarif')->default(10000)->after('experience');
        });

        Schema::table('users', function (Blueprint $table) {
            $table->string('sexe')->nullable()->after('birth_date');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('medecins', function (Blueprint $table) {
            $table->dropColumn(['experience', 'tarif']);
        });

        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('sexe');
        });
    }
};
