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
        Schema::table('triage_results', function (Blueprint $table) {
            $table->string('ml_risk_level')->nullable();
            $table->decimal('ml_confidence', 5, 4)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('triage_results', function (Blueprint $table) {
            $table->dropColumn(['ml_risk_level', 'ml_confidence']);
        });
    }
};
