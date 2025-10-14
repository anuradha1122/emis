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
        Schema::create('principal_transfers', function (Blueprint $table) {
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

            $table->string('appointmentLetterNo');
            $table->boolean('serviceConfirm')->default(false);
            $table->decimal('schoolDistance', 6, 2); // e.g., 12.25 km
            $table->string('position');
            $table->boolean('specialChildren');
            $table->boolean('expectTransfer');
            $table->string('reason')->nullable();

            // Preferred schools with distance (UUID)
            $table->uuid('school1Id')->nullable();
            $table->foreign('school1Id')->references('id')->on('schools')->restrictOnDelete();
            $table->decimal('distance1', 6, 2)->nullable();

            $table->uuid('school2Id')->nullable();
            $table->foreign('school2Id')->references('id')->on('schools')->restrictOnDelete();
            $table->decimal('distance2', 6, 2)->nullable();

            $table->uuid('school3Id')->nullable();
            $table->foreign('school3Id')->references('id')->on('schools')->restrictOnDelete();
            $table->decimal('distance3', 6, 2)->nullable();

            $table->uuid('school4Id')->nullable();
            $table->foreign('school4Id')->references('id')->on('schools')->restrictOnDelete();
            $table->decimal('distance4', 6, 2)->nullable();

            $table->uuid('school5Id')->nullable();
            $table->foreign('school5Id')->references('id')->on('schools')->restrictOnDelete();
            $table->decimal('distance5', 6, 2)->nullable();

            $table->boolean('anySchool');
            $table->string('mention')->nullable(); // additional notes
            $table->boolean('active')->default(true);

            $table->timestamps();
        });


    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('principal_transfers');
    }
};
