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
        Schema::create('user_service_appointment_positions', function (Blueprint $table) {
            // Primary key as UUID
            $table->uuid('id')->primary();
            $table->integer('incrementId')->unsigned()->unique();

            $table->integer('userServiceAppIncId')->unsigned()->unique();
            // FK to user_service_appointments (UUID)
            $table->uuid('userServiceAppId');
            $table->foreign('userServiceAppId')
                  ->references('id')
                  ->on('user_service_appointments')
                  ->restrictOnDelete();

            // FK to positions (auto-increment integer)
            $table->foreignId('positionId')
                  ->constrained('positions')
                  ->restrictOnDelete();

            $table->date('positionedDate');
            $table->date('releasedDate')->nullable();

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
        Schema::dropIfExists('user_service_appointment_positions');
    }
};
