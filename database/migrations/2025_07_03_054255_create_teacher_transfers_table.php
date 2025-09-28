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
        Schema::create('teacher_transfers', function (Blueprint $table) {
            $table->id();

            // Reference number
            $table->unsignedBigInteger('referenceNo');

            // Foreign key to user_in_services
            $table->foreignId('userServiceId')
                  ->constrained('user_in_services')
                  ->restrictOnDelete();

            // Foreign keys to transfer types and reasons
            $table->foreignId('typeId')
                  ->constrained('transfer_types')
                  ->restrictOnDelete();

            $table->foreignId('reasonId')
                  ->constrained('transfer_reasons')
                  ->restrictOnDelete();

            // Schools (primary choices)
            $table->foreignId('school1Id')
                  ->constrained('schools')
                  ->restrictOnDelete();

            $table->foreignId('school2Id')->nullable()
                  ->constrained('schools')
                  ->restrictOnDelete();

            $table->foreignId('school3Id')->nullable()
                  ->constrained('schools')
                  ->restrictOnDelete();

            $table->foreignId('school4Id')->nullable()
                  ->constrained('schools')
                  ->restrictOnDelete();

            $table->foreignId('school5Id')->nullable()
                  ->constrained('schools')
                  ->restrictOnDelete();

            // Any school flag
            $table->boolean('anySchool')->default(false);

            // Optional grade
            $table->tinyInteger('gradeId')->unsigned()->nullable();

            // Alternate schools
            $table->foreignId('alterSchool1Id')->nullable()
                  ->constrained('schools')
                  ->restrictOnDelete();

            $table->foreignId('alterSchool2Id')->nullable()
                  ->constrained('schools')
                  ->restrictOnDelete();

            $table->foreignId('alterSchool3Id')->nullable()
                  ->constrained('schools')
                  ->restrictOnDelete();

            $table->foreignId('alterSchool4Id')->nullable()
                  ->constrained('schools')
                  ->restrictOnDelete();

            $table->foreignId('alterSchool5Id')->nullable()
                  ->constrained('schools')
                  ->restrictOnDelete();

            // Extra fields
            $table->string('extraCurricular', 1000)->nullable();
            $table->string('mention', 1000)->nullable();

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
        Schema::dropIfExists('teacher_transfers');
    }
};
