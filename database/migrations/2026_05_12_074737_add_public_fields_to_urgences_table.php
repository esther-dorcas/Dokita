<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('urgences', function (Blueprint $table) {
            $table->unsignedBigInteger('patient_id')->nullable()->change();
            $table->string('nom_appelant')->nullable()->after('patient_id');
            $table->string('telephone')->nullable()->after('nom_appelant');
        });
    }

    public function down(): void
    {
        Schema::table('urgences', function (Blueprint $table) {
            $table->dropColumn(['nom_appelant', 'telephone']);
            $table->unsignedBigInteger('patient_id')->nullable(false)->change();
        });
    }
};
