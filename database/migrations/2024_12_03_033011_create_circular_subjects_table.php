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
        Schema::create('circular_subjects', function (Blueprint $table) {
            $table->id();

            // Foreign key to subjects
            $table->foreignId('subjectId')
                  ->constrained('subjects')
                  ->restrictOnDelete();

            // Foreign key to subject_media (medium)
            $table->foreignId('mediumId')
                  ->constrained('subject_media')
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
        Schema::dropIfExists('circular_subjects');
    }
};
