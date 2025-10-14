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
        Schema::create('family_infos', function (Blueprint $table) {
            // Primary key as UUID
            $table->uuid('id')->primary();

            // Foreign UUID to users
            $table->uuid('userId');
            $table->foreign('userId')
                  ->references('id')
                  ->on('users')
                  ->restrictOnDelete();

            // Foreign key to family_member_types (auto increment)
            $table->foreignId('memberTypeId')
                  ->nullable()
                  ->constrained('family_member_types')
                  ->nullOnDelete();

            $table->string('nic', 12)->nullable();
            $table->string('name', 200);

            // Foreign UUID to schools
            $table->uuid('schoolId')->nullable();
            $table->foreign('schoolId')
                  ->references('id')
                  ->on('schools')
                  ->nullOnDelete();

            $table->string('profession', 200)->nullable();

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
        Schema::dropIfExists('family_infos');
    }
};
