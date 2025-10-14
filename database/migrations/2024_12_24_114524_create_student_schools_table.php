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
            // Primary key as UUID
            $table->uuid('id')->primary();

            // Foreign UUIDs
            $table->uuid('studentId');
            $table->foreign('studentId')
                  ->references('id')
                  ->on('students')
                  ->restrictOnDelete();

            $table->uuid('schoolId');
            $table->foreign('schoolId')
                  ->references('id')
                  ->on('schools')
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
