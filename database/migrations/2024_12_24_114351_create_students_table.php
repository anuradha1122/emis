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
        Schema::create('students', function (Blueprint $table) {
            $table->id();

            $table->bigInteger('studentNo')->nullable()->unique();
            $table->string('identificationNo', 100)->nullable()->unique();
            $table->bigInteger('registerNo')->nullable();
            $table->string('nic')->nullable();
            $table->string('name');
            $table->string('nameWithInitials')->nullable();
            $table->string('email')->unique()->nullable();
            $table->timestamp('email_verified_at')->nullable();

            // Active flag
            $table->boolean('active')->default(true);

            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('students');
    }
};
