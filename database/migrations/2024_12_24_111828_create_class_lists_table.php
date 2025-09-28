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
        Schema::create('class_lists', function (Blueprint $table) {
            $table->id();

            $table->string('name', 50);

            // Foreign key to grades
            $table->foreignId('gradeId')
                  ->constrained('grades')
                  ->restrictOnDelete();

            // Foreign key to school_sections
            $table->foreignId('sectionId')
                  ->constrained('school_sections')
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
        Schema::dropIfExists('class_lists');
    }
};
