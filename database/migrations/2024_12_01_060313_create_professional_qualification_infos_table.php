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
        Schema::create('professional_qualification_infos', function (Blueprint $table) {
            // Primary key as UUID
            $table->uuid('id')->primary();

            // Foreign UUID to users
            $table->uuid('userId');
            $table->foreign('userId')
                  ->references('id')
                  ->on('users')
                  ->restrictOnDelete();

            // Foreign key to professional_qualifications (auto-increment)
            $table->foreignId('profQualiId')
                  ->nullable()
                  ->constrained('professional_qualifications')
                  ->nullOnDelete();

            // Effective date
            $table->date('effectiveDate');

            // Optional description
            $table->string('description', 100)->nullable();

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
        Schema::dropIfExists('professional_qualification_infos');
    }
};
