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
            $table->id();

            // Foreign key to users (UUID)
            $table->foreignId('userId')
                  ->constrained('users')
                  ->restrictOnDelete();

            // Foreign key to offices (education division, UUID)
            $table->foreignId('educationDivisionId')
                  ->nullable()
                  ->constrained('offices')
                  ->restrictOnDelete();

            // Foreign key to GN divisions (UUID)
            $table->foreignId('gnDivisionId')
                  ->nullable()
                  ->constrained('gn_divisions')
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
