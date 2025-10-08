<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('permissions', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique(); // e.g., "approve_transfers"
            $table->string('description')->nullable(); // optional human-readable explanation

            // Foreign key to permission_categories
            $table->unsignedBigInteger('categoryId');
            $table->foreign('categoryId')->references('id')->on('permission_categories')->onDelete('cascade');

            $table->boolean('active')->default(true);
            $table->timestamps();
        });
    }


    public function down(): void
    {
        Schema::dropIfExists('permissions');
    }
};
