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
        Schema::table('hopitaux', function (Blueprint $table) {
            $table->integer('capacite_lits')->nullable()->after('horaires');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('hopitaux', function (Blueprint $table) {
            $table->dropColumn('capacite_lits');
        });
    }
};
