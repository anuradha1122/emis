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
        Schema::create('offices', function (Blueprint $table) {
            $table->id();

            // FK to work_places
            $table->foreignId('workPlaceId')
                  ->constrained('work_places')
                  ->restrictOnDelete();

            $table->string('officeNo', 6);

            // self-referencing FK (nullable)
            $table->foreignId('higherOfficeId')
                  ->nullable()
                  ->constrained('offices')
                  ->nullOnDelete();

            // FK to districts (nullable)
            $table->foreignId('districtId')
                  ->nullable()
                  ->constrained('districts')
                  ->nullOnDelete();

            // FK to provinces
            $table->foreignId('provinceId')
                ->constrained('provinces')
                ->cascadeOnDelete(); // or restrictOnDelete()


            // FK to office_types
            $table->foreignId('officeTypeId')
                  ->constrained('office_types')
                  ->restrictOnDelete();

            $table->tinyInteger('active')->default(1);
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('offices');
    }
};
