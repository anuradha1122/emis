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
        Schema::create('schools', function (Blueprint $table) {
            $table->id();

            // Foreign keys (all UUIDs)
            $table->foreignId('workPlaceId')
                  ->constrained('work_places')
                  ->restrictOnDelete();

            $table->foreignId('officeId')
                  ->constrained('offices')
                  ->restrictOnDelete();

            $table->foreignId('authorityId')
                  ->nullable()
                  ->constrained('school_authorities')
                  ->restrictOnDelete();
            
            $table->foreignId('ethnicityId')
                  ->nullable()
                  ->constrained('school_ethnicities')
                  ->restrictOnDelete();
            
            $table->foreignId('languageId')
                  ->nullable()
                  ->constrained('school_languages')
                  ->restrictOnDelete();
            
            $table->foreignId('classId')
                  ->nullable()
                  ->constrained('school_classes')
                  ->restrictOnDelete();
            
            $table->foreignId('densityId')
                  ->nullable()
                  ->constrained('school_densities')
                  ->restrictOnDelete();
            
            $table->foreignId('genderId')
                  ->nullable()
                  ->constrained('school_genders')
                  ->restrictOnDelete();
            
            $table->foreignId('facilityId')
                  ->nullable()
                  ->constrained('school_facilities')
                  ->restrictOnDelete();
            
            $table->foreignId('religionId')
                  ->nullable()
                  ->constrained('school_religions')
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
        Schema::dropIfExists('schools');
    }
};
