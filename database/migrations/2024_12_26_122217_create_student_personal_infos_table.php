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
            $table->id();

            // One-to-one relationship with students
            $table->foreignId('studentId')
                  ->unique()
                  ->constrained('students')
                  ->restrictOnDelete();

            // Optional profile picture
            $table->string('profilePicture', 300)->nullable();

            // Foreign keys for lookup tables
            $table->foreignId('raceId')->nullable()->constrained('races');
            $table->foreignId('religionId')->nullable()->constrained('religions');
            $table->tinyInteger('genderId')->unsigned(); // required
            $table->foreignId('bloodGroupId')->nullable()->constrained('blood_groups');
            $table->foreignId('illnessId')->nullable()->constrained('illnesses');
            $table->foreignId('birthDsDivisionId')->nullable()->constrained('ds_divisions');

            // Birth details
            $table->date('birthDay');
            $table->string('birthCertificate', 100)->required(); // use string instead of int for flexibility

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
