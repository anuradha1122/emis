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
        Schema::create('role_permissions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('roleId');
            $table->unsignedBigInteger('permissionId');
            $table->timestamps();

            $table->foreign('roleId')->references('id')->on('roles')->onDelete('cascade');
            $table->foreign('permissionId')->references('id')->on('permissions')->onDelete('cascade');

            $table->unique(['roleId', 'permissionId']); // prevent duplicates
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('role_permissions');
    }
};
