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
            $table->id();

            // Foreign key to users
            $table->foreignId('userId')
                  ->constrained('users')
                  ->restrictOnDelete();

            // Foreign key to family_member_types (nullable)
            $table->foreignId('memberTypeId')
                  ->nullable()
                  ->constrained('family_member_types')
                  ->nullOnDelete();

            $table->string('nic', 12)->nullable();
            $table->string('name', 200);

            // Optional school reference (assuming schools.id is UUID)
            $table->foreignId('schoolId')
                  ->nullable()
                  ->constrained('schools')
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
