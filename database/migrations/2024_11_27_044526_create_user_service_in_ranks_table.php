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
        Schema::create('user_service_in_ranks', function (Blueprint $table) {
            $table->id();
            // Foreign key to user_in_services (UUID)
            $table->foreignId('userServiceId')
                  ->constrained('user_in_services')
                  ->restrictOnDelete();

            // Foreign key to ranks (if ranks.id is UUID, otherwise use foreignId)
            $table->foreignId('rankId')
                  ->constrained('ranks')
                  ->restrictOnDelete();

            $table->date('rankedDate');

            $table->boolean('current')->default(1);
            $table->boolean('active')->default(1);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_service_in_ranks');
    }
};
