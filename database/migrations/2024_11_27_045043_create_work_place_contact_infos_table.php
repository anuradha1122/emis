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
        Schema::create('work_place_contact_infos', function (Blueprint $table) {
            $table->id();

            // Foreign key to work_places
            $table->foreignId('workPlaceId')
                  ->constrained('work_places')
                  ->restrictOnDelete()
                  ->unique(); // assuming one contact info per workplace

            $table->string('addressLine1', 80);
            $table->string('addressLine2', 80);
            $table->string('addressLine3', 80);

            $table->string('mobile1', 10)->unique();
            $table->string('mobile2', 10)->nullable()->unique(); // mobile2 may not be required

            $table->boolean('active')->default(true);

            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('work_place_contact_infos');
    }
};
