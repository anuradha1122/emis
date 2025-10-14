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
        Schema::create('user_service_accounts', function (Blueprint $table) {
            // Primary key as UUID
            $table->uuid('id')->primary();

            // Foreign UUID to user_in_services
            $table->uuid('userServiceId');
            $table->foreign('userServiceId')
                  ->references('id')
                  ->on('user_in_services')
                  ->restrictOnDelete();

            // Account year
            $table->unsignedSmallInteger('year');

            // Increment date
            $table->date('incrementDate');

            // Flags
            $table->boolean('current')->default(true);
            $table->boolean('active')->default(true);

            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_service_accounts');
    }
};
