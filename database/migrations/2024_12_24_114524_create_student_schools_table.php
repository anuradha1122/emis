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
        Schema::create('student_schools', function (Blueprint $table) {
            $table->id();

            // Foreign keys
            $table->foreignId('studentId')
                  ->constrained('students')
                  ->restrictOnDelete();

            $table->foreignId('schoolId')
                  ->constrained('schools')
                  ->restrictOnDelete();

            $table->date('appointedDate');
            $table->date('releasedDate')->nullable();

            // Current and active flags
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
        Schema::dropIfExists('student_schools');
    }
};
