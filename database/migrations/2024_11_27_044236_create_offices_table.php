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
            // UUID primary key
            $table->uuid('id')->primary();
            $table->integer('incrementId')->unsigned()->unique();
            $table->integer('workPlaceIncrementId')->unsigned()->unique();
            // FK to work_places (UUID)
            $table->uuid('workPlaceId');
            $table->foreign('workPlaceId')
                ->references('id')
                ->on('work_places')
                ->restrictOnDelete();

            $table->string('officeNo', 6);

            // Self-referencing FK (UUID, nullable)
            $table->uuid('higherOfficeId')->nullable();
            $table->foreign('higherOfficeId')
                ->references('id')
                ->on('offices')
                ->nullOnDelete();

            // FK to districts (auto-increment, still fine)
            $table->foreignId('districtId')
                ->nullable()
                ->constrained('districts')
                ->nullOnDelete();

            // FK to provinces (auto-increment)
            $table->foreignId('provinceId')
                ->constrained('provinces')
                ->cascadeOnDelete();

            // FK to office_types (auto-increment)
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
