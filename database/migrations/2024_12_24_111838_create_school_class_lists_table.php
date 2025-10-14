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
        Schema::create('school_class_lists', function (Blueprint $table) {
            // Primary key as UUID
            $table->uuid('id')->primary();

            // Foreign UUIDs
            $table->uuid('schoolId');
            $table->foreign('schoolId')
                ->references('id')
                ->on('schools')
                ->restrictOnDelete();

            // Auto-increment foreign keys
            $table->foreignId('classId')
                ->constrained('class_lists')
                ->restrictOnDelete();

            // Nullable foreign UUID for teacher
            $table->uuid('teacherId')->nullable();
            $table->foreign('teacherId')
                ->references('id')
                ->on('user_service_appointments')
                ->nullOnDelete();

            // Auto-increment foreign key (optional medium)
            $table->foreignId('mediumId')
                ->nullable()
                ->constrained('class_media')
                ->nullOnDelete();

            $table->integer('studentCount')->unsigned()->nullable();
            $table->tinyInteger('year')->unsigned()->nullable();

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
        Schema::dropIfExists('school_class_lists');
    }
};
