<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('courses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('semester_id')->constrained()->onDelete('cascade');
            $table->string('code', 50);
            $table->string('name');
            $table->integer('credits')->default(3);
            $table->string('instructor')->nullable();
            $table->string('instructor_email')->nullable();
            $table->string('schedule')->nullable();
            $table->string('room', 100)->nullable();
            $table->decimal('target_grade', 5, 2)->nullable();
            $table->decimal('current_grade', 5, 2)->nullable();
            $table->string('color_code', 20)->default('#667eea');
            $table->text('description')->nullable();
            $table->text('notes')->nullable();
            $table->string('textbook')->nullable();
            $table->string('status', 20)->default('active');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('courses');
    }
};