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
        Schema::create('student_contact_infos', function (Blueprint $table) {
            // Primary key as UUID
            $table->uuid('id')->primary();

            // One-to-one relationship with students (UUID)
            $table->uuid('studentId')->unique();
            $table->foreign('studentId')
                  ->references('id')
                  ->on('students')
                  ->restrictOnDelete();

            // Student address
            $table->string('addressLine1', 100);
            $table->string('addressLine2', 100);
            $table->string('addressLine3', 100)->nullable();

            // Student mobile
            $table->string('mobile', 10)->nullable();

            // Mother details
            $table->string('motherName', 200)->nullable();
            $table->string('motherNic', 12)->nullable();
            $table->string('motherMobile', 10)->nullable();
            $table->string('motherEmail', 80)->nullable();

            // Father details
            $table->string('fatherName', 200)->nullable();
            $table->string('fatherNic', 12)->nullable();
            $table->string('fatherMobile', 10)->nullable();
            $table->string('fatherEmail', 80)->nullable();

            // Guardian details
            $table->string('guardianName', 200)->nullable();
            $table->string('guardianNic', 12)->nullable();
            $table->foreignId('guardianRelationshipId')
                  ->nullable()
                  ->constrained('guardian_relationships')
                  ->nullOnDelete();
            $table->string('guardianMobile', 10)->nullable();
            $table->string('guardianEmail', 80)->nullable();

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
        Schema::dropIfExists('student_contact_infos');
    }
};
