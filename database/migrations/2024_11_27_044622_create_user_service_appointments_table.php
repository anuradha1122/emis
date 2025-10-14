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
            // Primary key as UUID
            $table->uuid('id')->primary();
            $table->integer('incrementId')->unsigned()->unique();

            $table->integer('userServiceIncrementId')->unsigned()->unique();
            // FK to user_in_services (UUID)
            $table->uuid('userServiceId');
            $table->foreign('userServiceId')
                  ->references('id')
                  ->on('user_in_services')
                  ->restrictOnDelete();

            $table->integer('workPlaceIncrementId')->unsigned()->unique();
            // FK to work_places (UUID)
            $table->uuid('workPlaceId');
            $table->foreign('workPlaceId')
                  ->references('id')
                  ->on('work_places')
                  ->restrictOnDelete();

            // FK to appointment_terminations (auto-increment integer)
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
