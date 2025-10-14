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
        Schema::create('school_class_subjects', function (Blueprint $table) {
            // Primary key as UUID
            $table->uuid('id')->primary();

            // Foreign UUID
            $table->uuid('schoolClassId');
            $table->foreign('schoolClassId')
                  ->references('id')
                  ->on('school_class_lists')
                  ->restrictOnDelete();

            // Foreign keys to lookup tables (auto-increment integers)
            $table->foreignId('subjectId')
                  ->constrained('subjects')
                  ->restrictOnDelete();

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
        Schema::dropIfExists('school_class_subjects');
    }
};
