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
            $table->id();

            // FK to users (uuid instead of int)
            $table->foreignId('userId')->unique()->constrained('users')->restrictOnDelete();

            // Permanent address (all required)
            $table->string('permAddressLine1', 80)->nullable();
            $table->string('permAddressLine2', 80)->nullable();
            $table->string('permAddressLine3', 80)->nullable();

            // Temporary address (optional)
            $table->string('tempAddressLine1', 80)->nullable();
            $table->string('tempAddressLine2', 80)->nullable();
            $table->string('tempAddressLine3', 80)->nullable();

            // Mobile numbers
            $table->string('mobile1', 15)->nullable()->unique(); // primary, required
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
