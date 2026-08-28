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
    Schema::create('referrals', function (Blueprint $table) {
        $table->id();
        $table->foreignId('patient_id')->constrained('patients');
        $table->foreignId('triage_result_id')->constrained('triage_results');
        $table->string('facility_name')->nullable();
        $table->enum('status', ['pending', 'referred', 'completed'])->default('pending');
        $table->timestamp('referral_date')->nullable();
        $table->timestamps();
    });
}
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('referrals');
    }
};
