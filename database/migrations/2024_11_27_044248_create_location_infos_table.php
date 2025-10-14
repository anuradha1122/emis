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
        Schema::create('location_infos', function (Blueprint $table) {
            // Primary key as UUID
            $table->uuid('id')->primary();

            // FK to users (UUID)
            $table->uuid('userId');
            $table->foreign('userId')
                  ->references('id')
                  ->on('users')
                  ->restrictOnDelete();

            // FK to offices (UUID)
            $table->uuid('educationDivisionId')->nullable();
            $table->foreign('educationDivisionId')
                  ->references('id')
                  ->on('offices')
                  ->restrictOnDelete();

            // FK to gn_divisions (UUID)
            $table->uuid('gnDivisionId')->nullable();
            $table->foreign('gnDivisionId')
                  ->references('id')
                  ->on('gn_divisions')
                  ->restrictOnDelete();

            $table->tinyInteger('active')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('location_infos');
    }
};
