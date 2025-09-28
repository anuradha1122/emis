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
            $table->id();

            // Foreign key to users (if users.id is UUID)
            $table->foreignId('userId')
                  ->constrained('users')
                  ->restrictOnDelete();

            // Foreign key to services (if services.id is UUID)
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
