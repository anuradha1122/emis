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
            $table->id();
            // Reference number
            $table->unsignedBigInteger('referenceNo');

            // Foreign key to user_in_services
            $table->foreignId('userServiceId')
                  ->constrained('user_in_services')
                  ->restrictOnDelete();

            $table->string('appointmentLetterNo');
            $table->boolean('serviceConfirm')->default(false);
            $table->decimal('schoolDistance', 6, 2); // e.g., 12.25 km
            $table->string('position');
            $table->boolean('specialChildren');
            $table->boolean('expectTransfer');
            $table->string('reason')->nullable();

            // Preferred schools with distance
            $table->foreignId('school1Id')->nullable()
                  ->constrained('schools')
                  ->restrictOnDelete();
            $table->decimal('distance1', 6, 2)->nullable();

            $table->foreignId('school2Id')->nullable()
                  ->constrained('schools')
                  ->restrictOnDelete();
            $table->decimal('distance2', 6, 2)->nullable();

            $table->foreignId('school3Id')->nullable()
                  ->constrained('schools')
                  ->restrictOnDelete();
            $table->decimal('distance3', 6, 2)->nullable();

            $table->foreignId('school4Id')->nullable()
                  ->constrained('schools')
                  ->restrictOnDelete();
            $table->decimal('distance4', 6, 2)->nullable();

            $table->foreignId('school5Id')->nullable()
                  ->constrained('schools')
                  ->restrictOnDelete();
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
