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
        Schema::create('user_service_appointments', function (Blueprint $table) {
            $table->id();

            // Foreign UUIDs
            $table->foreignId('userServiceId')
                  ->constrained('user_in_services')
                  ->restrictOnDelete();

            $table->foreignId('workPlaceId')
                  ->constrained('work_places')
                  ->restrictOnDelete();

            $table->foreignId('reason')
                  ->nullable()
                  ->constrained('appointment_terminations')
                  ->nullOnDelete();

            $table->tinyInteger('appointmentType')->default(1);

            // Appointment details
            $table->date('appointedDate');
            $table->date('releasedDate')->nullable();

            // Status flags
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
        Schema::dropIfExists('user_service_appointments');
    }
};
