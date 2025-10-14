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
            // Primary key as UUID
            $table->uuid('id')->primary();

            // Reference number
            $table->unsignedBigInteger('referenceNo');

            // Foreign UUID to user_in_services
            $table->uuid('userServiceId');
            $table->foreign('userServiceId')
                ->references('id')
                ->on('user_in_services')
                ->restrictOnDelete();

            // Foreign keys to lookup tables (auto-increment)
            $table->foreignId('typeId')
                ->constrained('transfer_types')
                ->restrictOnDelete();

            $table->foreignId('reasonId')
                ->constrained('transfer_reasons')
                ->restrictOnDelete();

            // Schools (primary choices, UUID)
            $table->uuid('school1Id');
            $table->foreign('school1Id')->references('id')->on('schools')->restrictOnDelete();

            $table->uuid('school2Id')->nullable();
            $table->foreign('school2Id')->references('id')->on('schools')->restrictOnDelete();

            $table->uuid('school3Id')->nullable();
            $table->foreign('school3Id')->references('id')->on('schools')->restrictOnDelete();

            $table->uuid('school4Id')->nullable();
            $table->foreign('school4Id')->references('id')->on('schools')->restrictOnDelete();

            $table->uuid('school5Id')->nullable();
            $table->foreign('school5Id')->references('id')->on('schools')->restrictOnDelete();

            // Any school flag
            $table->boolean('anySchool')->default(false);

            // Grade (auto-increment foreign key)
            $table->foreignId('gradeId')->nullable()->constrained('grades')->restrictOnDelete();

            // Alternate schools (UUID)
            $table->uuid('alterSchool1Id')->nullable();
            $table->foreign('alterSchool1Id')->references('id')->on('schools')->restrictOnDelete();

            $table->uuid('alterSchool2Id')->nullable();
            $table->foreign('alterSchool2Id')->references('id')->on('schools')->restrictOnDelete();

            $table->uuid('alterSchool3Id')->nullable();
            $table->foreign('alterSchool3Id')->references('id')->on('schools')->restrictOnDelete();

            $table->uuid('alterSchool4Id')->nullable();
            $table->foreign('alterSchool4Id')->references('id')->on('schools')->restrictOnDelete();

            $table->uuid('alterSchool5Id')->nullable();
            $table->foreign('alterSchool5Id')->references('id')->on('schools')->restrictOnDelete();

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
