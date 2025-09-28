<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('position_permissions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('positionId');
            $table->unsignedBigInteger('permissionId');
            $table->timestamps();

            $table->foreign('positionId')->references('id')->on('positions')->onDelete('cascade');
            $table->foreign('permissionId')->references('id')->on('permissions')->onDelete('cascade');

            $table->unique(['positionId', 'permissionId']); // prevent duplicates
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('position_permissions');
    }
};
