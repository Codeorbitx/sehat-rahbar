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
    Schema::create('screenings', function (Blueprint $table) {
        $table->id();
        $table->foreignId('patient_id')->constrained('patients');
        $table->foreignId('lhw_id')->constrained('users');
        $table->integer('bp_systolic')->nullable();
        $table->integer('bp_diastolic')->nullable();
        $table->decimal('glucose_level', 5, 2)->nullable();
        $table->decimal('hemoglobin_level', 5, 2)->nullable();
        $table->boolean('swelling')->default(false);
        $table->boolean('severe_headache')->default(false);
        $table->boolean('vision_issues')->default(false);
        $table->boolean('low_fetal_movement')->default(false);
        $table->text('other_symptoms')->nullable();
        $table->timestamps();
    });
}
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('screenings');
    }
};
