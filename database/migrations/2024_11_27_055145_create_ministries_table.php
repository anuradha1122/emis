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
        Schema::create('ministries', function (Blueprint $table) {
            $table->id();

            // Foreign key to work_places
            $table->foreignId('workPlaceId')
                  ->constrained('work_places')
                  ->restrictOnDelete();

            // Foreign key to offices (nullable)
            $table->foreignId('officeId')
                  ->nullable()
                  ->constrained('offices')
                  ->nullOnDelete();

            // Foreign key to ministry_types (nullable)
            $table->foreignId('ministryTypeId')
                  ->nullable()
                  ->constrained('ministry_types')
                  ->nullOnDelete();

            $table->string('ministryNo', 4);

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
        Schema::dropIfExists('ministries');
    }
};
