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
        Schema::create('vitals', function (Blueprint $table) {
            $table->id();
            $table->foreignId('patient_id')->constrained('patients')->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->float('temperature', 4, 1); // e.g., 98.6
            $table->integer('heart_rate')->unsigned(); // beats per minute
            $table->integer('respiratory_rate')->unsigned(); // breaths per minute
            $table->integer('blood_pressure_systolic')->unsigned(); // mm Hg
            $table->integer('blood_pressure_diastolic')->unsigned(); // mm 
            $table->integer('oxygen_saturation')->unsigned(); // percentage
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vitals');
    }
};
