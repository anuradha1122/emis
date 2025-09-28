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
        Schema::create('school_class_students', function (Blueprint $table) {
            $table->id();

            // Foreign keys
            $table->foreignId('schoolClassId')
                  ->constrained('school_class_lists')
                  ->restrictOnDelete();

            $table->foreignId('studentId')
                  ->constrained('students')
                  ->restrictOnDelete();

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
        Schema::dropIfExists('school_class_students');
    }
};
