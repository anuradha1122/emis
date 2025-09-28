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
            $table->id();

            // Foreign key to users
            $table->foreignId('userId')
                  ->constrained('users')
                  ->restrictOnDelete();

            // Foreign key to education_qualifications (nullable)
            $table->foreignId('eduQualiId')
                  ->nullable()
                  ->constrained('education_qualifications')
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
        Schema::dropIfExists('education_qualification_infos');
    }
};
