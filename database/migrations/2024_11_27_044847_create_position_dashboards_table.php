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
        Schema::create('position_dashboards', function (Blueprint $table) {
            $table->id();

            // Foreign key to positions
            $table->foreignId('positionId')
                  ->constrained('positions')
                  ->restrictOnDelete();

            // Foreign key to dashboards
            $table->foreignId('dashboardId')
                  ->constrained('dashboards')
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
        Schema::dropIfExists('position_dashboards');
    }
};
