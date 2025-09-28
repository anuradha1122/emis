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
        Schema::create('teacher_services', function (Blueprint $table) {
            $table->id();

            // Foreign keys
            $table->foreignId('userServiceId')
                  ->constrained('user_in_services')
                  ->restrictOnDelete();

            $table->foreignId('appointmentSubjectId')
                  ->constrained('subjects')
                  ->restrictOnDelete();

            $table->foreignId('mainSubjectId')
                  ->constrained('subjects')
                  ->restrictOnDelete();

            $table->foreignId('appointmentMediumId')
                  ->constrained('subject_media')
                  ->restrictOnDelete();

            $table->foreignId('appointmentCategoryId')
                  ->constrained('appointment_categories')
                  ->restrictOnDelete();

            // Active flag
            $table->boolean('active')->default(true);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('teacher_services');
    }
};
