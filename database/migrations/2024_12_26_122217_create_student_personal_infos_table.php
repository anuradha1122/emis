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
        Schema::create('student_personal_infos', function (Blueprint $table) {
            // Primary key as UUID
            $table->uuid('id')->primary();

            // One-to-one relationship with students (UUID)
            $table->uuid('studentId')->unique();
            $table->foreign('studentId')
                  ->references('id')
                  ->on('students')
                  ->restrictOnDelete();

            // Optional profile picture
            $table->string('profilePicture', 300)->nullable();

            // Foreign keys for lookup tables (auto-increment)
            $table->foreignId('raceId')->nullable()->constrained('races');
            $table->foreignId('religionId')->nullable()->constrained('religions');
            $table->tinyInteger('genderId')->unsigned(); // required
            $table->foreignId('bloodGroupId')->nullable()->constrained('blood_groups');
            $table->foreignId('illnessId')->nullable()->constrained('illnesses');
            $table->uuid('birthDsDivisionId')->nullable();
            $table->foreign('birthDsDivisionId')
                ->references('id')
                ->on('ds_divisions')
                ->nullOnDelete();

            // Birth details
            $table->date('birthDay');
            $table->string('birthCertificate', 100);

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
        Schema::dropIfExists('student_personal_infos');
    }
};
