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
        Schema::create('education_qualification_infos', function (Blueprint $table) {
            // Primary key as UUID
            $table->uuid('id')->primary();

            // Foreign UUID to users
            $table->uuid('userId');
            $table->foreign('userId')
                  ->references('id')
                  ->on('users')
                  ->restrictOnDelete();

            // Foreign key to education_qualifications (auto-increment)
            $table->foreignId('eduQualiId')
                  ->nullable()
                  ->constrained('education_qualifications')
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
        Schema::dropIfExists('education_qualification_infos');
    }
};
