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
            // Primary key as UUID
            $table->uuid('id')->primary();

            // Foreign UUIDs
            $table->uuid('workPlaceId');
            $table->foreign('workPlaceId')
                  ->references('id')
                  ->on('work_places')
                  ->restrictOnDelete();

            $table->uuid('officeId');
            $table->foreign('officeId')
                  ->references('id')
                  ->on('offices')
                  ->restrictOnDelete();

            $table->mediumInteger('centerNo')->unsigned();

            // Foreign key to center_types (auto-increment integer)
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
