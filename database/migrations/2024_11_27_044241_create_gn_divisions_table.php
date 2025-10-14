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
        Schema::create('gn_divisions', function (Blueprint $table) {
            // Primary key as UUID
            $table->uuid('id')->primary();

            // FK to ds_divisions (UUID)
            $table->uuid('dsId');
            $table->foreign('dsId')
                  ->references('id')
                  ->on('ds_divisions')
                  ->restrictOnDelete();

            $table->string('name', 50);
            $table->string('gnCode', 60);
            $table->unsignedInteger('area'); // hectares/sq km etc.
            $table->tinyInteger('active')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('gn_divisions');
    }
};
