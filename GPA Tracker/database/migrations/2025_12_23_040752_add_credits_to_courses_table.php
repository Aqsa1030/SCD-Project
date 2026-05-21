<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('courses', function (Blueprint $table) {
            // First, check what columns exist
            $columns = Schema::getColumnListing('courses');
            
            // Add code column first (no dependency)
            if (!in_array('code', $columns)) {
                $table->string('code', 50)->after('semester_id');
            }
            
            // Add name column (no dependency)
            if (!in_array('name', $columns)) {
                $table->string('name')->after('id');
            }
            
            // Add credits column (no dependency on name position)
            if (!in_array('credits', $columns)) {
                $table->integer('credits')->default(3)->after('id');
            }
            
            // Add other columns
            if (!in_array('instructor_email', $columns)) {
                $table->string('instructor_email')->nullable();
            }
            
            if (!in_array('target_grade', $columns)) {
                $table->decimal('target_grade', 5, 2)->nullable();
            }
            
            if (!in_array('current_grade', $columns)) {
                $table->decimal('current_grade', 5, 2)->nullable();
            }
            
            if (!in_array('color_code', $columns)) {
                $table->string('color_code', 20)->default('#667eea');
            }
            
            if (!in_array('description', $columns)) {
                $table->text('description')->nullable();
            }
            
            if (!in_array('notes', $columns)) {
                $table->text('notes')->nullable();
            }
            
            if (!in_array('textbook', $columns)) {
                $table->string('textbook')->nullable();
            }
            
            if (!in_array('status', $columns)) {
                $table->string('status', 20)->default('active');
            }
        });
    }

    public function down(): void
    {
        Schema::table('courses', function (Blueprint $table) {
            $columns = ['code', 'name', 'credits', 'instructor_email', 'target_grade', 
                       'current_grade', 'color_code', 'description', 'notes', 'textbook', 'status'];
            
            foreach ($columns as $column) {
                if (Schema::hasColumn('courses', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
    }
};