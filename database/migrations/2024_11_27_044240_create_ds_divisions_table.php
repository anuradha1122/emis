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
        Schema::create('ds_divisions', function (Blueprint $table) {
            $table->uuid('id')->primary();

            // FK to districts
            $table->foreignId('districtId')->constrained('districts')->restrictOnDelete();

            $table->string('name', 50);
            $table->tinyInteger('active')->default(1);
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ds_divisions');
    }
};
