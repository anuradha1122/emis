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
        Schema::create('student_location_infos', function (Blueprint $table) {
            $table->id();

            // Foreign key to students
            $table->foreignId('studentId')
                  ->constrained('students')
                  ->restrictOnDelete();

            // Foreign keys for divisions (optional)
            $table->foreignId('educationDivisionId')
                  ->nullable()
                  ->constrained('offices') // Assuming education divisions are stored in offices table
                  ->nullOnDelete();

            $table->foreignId('gnDivisionId')
                  ->nullable()
                  ->constrained('gn_divisions')
                  ->nullOnDelete();

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
        Schema::dropIfExists('student_location_infos');
    }
};
