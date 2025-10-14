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
            // Primary key as UUID
            $table->uuid('id')->primary();

            $table->integer('incrementId')->unsigned()->unique();
            $table->integer('workPlaceIncrementId')->unsigned()->unique();
            // Foreign UUIDs
            $table->uuid('workPlaceId');
            $table->foreign('workPlaceId')
                  ->references('id')
                  ->on('work_places')
                  ->restrictOnDelete();

            $table->integer('officeIncrementId')->unsigned()->nullable();
            $table->uuid('officeId')->nullable();
            $table->foreign('officeId')
                  ->references('id')
                  ->on('offices')
                  ->nullOnDelete();

            // Foreign key to ministry_types (auto increment)
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
