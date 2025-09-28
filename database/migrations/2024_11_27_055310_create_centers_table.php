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
        Schema::create('centers', function (Blueprint $table) {
            $table->id();

            // Foreign key to work_places
            $table->foreignId('workPlaceId')
                  ->constrained('work_places')
                  ->restrictOnDelete();

            // Foreign key to offices
            $table->foreignId('officeId')
                  ->constrained('offices')
                  ->restrictOnDelete();

            $table->mediumInteger('centerNo')->unsigned();

            // Foreign key to center_types
            $table->foreignId('centerTypeId')
                  ->constrained('center_types')
                  ->restrictOnDelete();

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
        Schema::dropIfExists('centers');
    }
};
