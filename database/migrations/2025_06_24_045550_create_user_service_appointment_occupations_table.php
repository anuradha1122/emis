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
        Schema::create('user_service_appointment_occupations', function (Blueprint $table) {
            $table->id();

            // Foreign key to user_service_appointments
            $table->foreignId('userServiceAppId')
                  ->constrained('user_service_appointments')
                  ->restrictOnDelete();

            // Foreign key to occupations
            $table->foreignId('occupationId')
                  ->constrained('occupations')
                  ->restrictOnDelete();

            // Occupation start and end dates
            $table->date('startedDate');
            $table->date('releasedDate')->nullable();

            // Flags
            $table->boolean('current')->default(true);
            $table->boolean('active')->default(true);

            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_service_appointment_occupations');
    }
};
