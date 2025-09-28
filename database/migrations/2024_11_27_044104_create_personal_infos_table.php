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
        Schema::create('personal_infos', function (Blueprint $table) {
            $table->id(); 

            // Link to users (1-to-1, each user has only one personal info record)
            $table->foreignId('userId')->unique()->constrained('users')->cascadeOnDelete();

            // Profile picture path (nullable)
            $table->string('profilePicture', 300)->nullable();

            // Foreign keys to lookup tables (tinyint is fine if you have <255 records in each)

            $table->foreignId('raceId')->nullable()->constrained('races')->restrictOnDelete();
            $table->foreignId('religionId')->nullable()->constrained('religions')->restrictOnDelete();
            $table->foreignId('civilStatusId')->nullable()->constrained('civil_statuses')->restrictOnDelete();
            $table->tinyInteger('genderId')->unsigned()->nullable(); // now optional
            $table->foreignId('bloodGroupId')->nullable()->constrained('blood_groups')->restrictOnDelete();
            $table->foreignId('illnessId')->nullable()->constrained('illnesses')->restrictOnDelete();


            // Birthday is required
            $table->date('birthDay');

            $table->tinyInteger('active')->default(1);

            $table->timestamps();
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('personal_infos');
    }
};
