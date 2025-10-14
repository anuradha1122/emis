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
            // Primary key as UUID
            $table->uuid('id')->primary();

            // Foreign UUID to students
            $table->uuid('studentId');
            $table->foreign('studentId')
                  ->references('id')
                  ->on('students')
                  ->restrictOnDelete();

            // Foreign UUIDs for divisions
            $table->uuid('educationDivisionId')->nullable();
            $table->foreign('educationDivisionId')
                  ->references('id')
                  ->on('offices')
                  ->nullOnDelete();

            $table->uuid('gnDivisionId')->nullable();
            $table->foreign('gnDivisionId')
                  ->references('id')
                  ->on('gn_divisions')
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
