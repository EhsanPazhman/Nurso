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
            $table->foreignId('user_id')->constrained('users'); 

            $table->integer('systolic')->nullable();  
            $table->integer('diastolic')->nullable(); 
            $table->decimal('temperature', 4, 1)->nullable(); 
            $table->integer('pulse_rate')->nullable(); 
            $table->integer('respiratory_rate')->nullable(); 
            $table->integer('spo2')->nullable(); 
            $table->decimal('weight', 5, 2)->nullable(); 

            $table->text('nursing_note')->nullable();

            $table->timestamp('recorded_at'); 
            $table->timestamps();
            $table->softDeletes();

            $table->index(['patient_id', 'recorded_at']);
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
