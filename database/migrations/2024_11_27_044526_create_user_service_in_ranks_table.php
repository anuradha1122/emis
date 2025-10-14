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
            // Primary key as UUID
            $table->uuid('id')->primary();
            $table->integer('incrementId')->unsigned()->unique();

            $table->integer('userServiceIncrementId')->unsigned()->unique();
            // FK to user_in_services (UUID)
            $table->uuid('userServiceId');
            $table->foreign('userServiceId')
                  ->references('id')
                  ->on('user_in_services')
                  ->restrictOnDelete();

            // FK to ranks (auto-increment integer)
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
