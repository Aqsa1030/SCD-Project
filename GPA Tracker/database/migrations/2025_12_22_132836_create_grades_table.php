<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('grades', function (Blueprint $table) {
            $table->id();
            $table->foreignId('course_id')->constrained()->onDelete('cascade');
            $table->enum('assessment_type', ['Quiz', 'Assignment', 'Midterm', 'Final', 'Project', 'Presentation', 'Lab']);
            $table->string('title');
            $table->float('weightage', 5, 2);
            $table->float('marks_obtained', 5, 2)->nullable();
            $table->float('total_marks', 5, 2);
            $table->date('date');
            $table->enum('status', ['pending', 'completed', 'graded'])->default('pending');
            $table->text('remarks')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('grades');
    }
};