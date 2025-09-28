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
        Schema::create('professional_qualifications', function (Blueprint $table) {
            $table->id();

            $table->string('name', 100);

            // Qualification level (numeric)
            $table->tinyInteger('qualificationLevel')->unsigned();

            // Foreign key to professional_qualification_types
            $table->foreignId('qualificationTypeId')
                  ->constrained('professional_qualification_types')
                  ->restrictOnDelete();

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
        Schema::dropIfExists('professional_qualifications');
    }
};
