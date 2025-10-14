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
        Schema::create('user_in_services', function (Blueprint $table) {
            // Primary key as UUID
            $table->uuid('id')->primary();
            $table->integer('incrementId')->unsigned()->unique();

            $table->integer('userIncrementId')->unsigned();
            // FK to users (UUID)
            $table->uuid('userId');
            $table->foreign('userId')
                  ->references('id')
                  ->on('users')
                  ->restrictOnDelete();

            // FK to services (auto-increment integer)
            $table->foreignId('serviceId')
                  ->constrained('services')
                  ->restrictOnDelete();

            $table->date('appointedDate');
            $table->date('releasedDate')->nullable();

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
        Schema::dropIfExists('user_in_services');
    }
};
