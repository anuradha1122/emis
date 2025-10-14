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
        Schema::create('work_place_contact_infos', function (Blueprint $table) {
            // Primary key as UUID
            $table->uuid('id')->primary();

            // Foreign key to work_places (UUID)
            $table->uuid('workPlaceId')->unique();
            $table->foreign('workPlaceId')
                  ->references('id')
                  ->on('work_places')
                  ->restrictOnDelete();

            // Address lines
            $table->string('addressLine1', 80);
            $table->string('addressLine2', 80);
            $table->string('addressLine3', 80);

            // Contact numbers
            $table->string('mobile1', 10)->unique();
            $table->string('mobile2', 10)->nullable()->unique();

            // Status
            $table->boolean('active')->default(true);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('work_place_contact_infos');
    }
};
