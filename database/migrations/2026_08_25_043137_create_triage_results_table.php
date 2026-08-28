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
    Schema::create('triage_results', function (Blueprint $table) {
        $table->id();
        $table->foreignId('screening_id')->constrained('screenings');
        $table->enum('priority_level', ['low', 'moderate', 'high']);
        $table->text('reasons');
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('triage_results');
    }
};
