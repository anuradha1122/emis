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
            $table->id();

            // Foreign key to users
            $table->foreignId('userId')
                  ->constrained('users')
                  ->restrictOnDelete();

            // Foreign key to professional_qualifications (nullable)
            $table->foreignId('profQualiId')
                  ->nullable()
                  ->constrained('professional_qualifications')
                  ->nullOnDelete();

            $table->date('effectiveDate');

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
