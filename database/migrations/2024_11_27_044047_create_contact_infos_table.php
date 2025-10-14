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
        Schema::create('contact_infos', function (Blueprint $table) {
            // UUID primary key
            $table->uuid('id')->primary();

            // FK to users (uuid)
            $table->uuid('userId')->unique();
            $table->foreign('userId')->references('id')->on('users')->restrictOnDelete();

            // Permanent address (all nullable)
            $table->string('permAddressLine1', 80)->nullable();
            $table->string('permAddressLine2', 80)->nullable();
            $table->string('permAddressLine3', 80)->nullable();

            // Temporary address (all nullable)
            $table->string('tempAddressLine1', 80)->nullable();
            $table->string('tempAddressLine2', 80)->nullable();
            $table->string('tempAddressLine3', 80)->nullable();

            // Mobile numbers
            $table->string('mobile1', 15)->nullable()->unique(); // primary, optional
            $table->string('mobile2', 15)->nullable(); // secondary, optional

            $table->tinyInteger('active')->default(1);

            $table->timestamps();
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contact_infos');
    }
};
