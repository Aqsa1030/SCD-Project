<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('courses', function (Blueprint $table) {
            // Add code column if it doesn't exist
            if (!Schema::hasColumn('courses', 'code')) {
                $table->string('code', 50)->after('semester_id');
            }
            
            // Add name column if it doesn't exist
            if (!Schema::hasColumn('courses', 'name')) {
                $table->string('name')->after('code');
            }
            
            // Add credits column if it doesn't exist
            if (!Schema::hasColumn('courses', 'credits')) {
                $table->integer('credits')->default(3)->after('name');
            }
            
            // Add instructor_email if missing
            if (!Schema::hasColumn('courses', 'instructor_email')) {
                $table->string('instructor_email')->nullable()->after('instructor');
            }
            
            // Add target_grade if missing
            if (!Schema::hasColumn('courses', 'target_grade')) {
                $table->decimal('target_grade', 5, 2)->nullable()->after('room');
            }
            
            // Add current_grade if missing
            if (!Schema::hasColumn('courses', 'current_grade')) {
                $table->decimal('current_grade', 5, 2)->nullable()->after('target_grade');
            }
            
            // Add color_code if missing
            if (!Schema::hasColumn('courses', 'color_code')) {
                $table->string('color_code', 20)->default('#667eea')->after('current_grade');
            }
            
            // Add description if missing
            if (!Schema::hasColumn('courses', 'description')) {
                $table->text('description')->nullable()->after('color_code');
            }
            
            // Add notes if missing
            if (!Schema::hasColumn('courses', 'notes')) {
                $table->text('notes')->nullable()->after('description');
            }
            
            // Add textbook if missing
            if (!Schema::hasColumn('courses', 'textbook')) {
                $table->string('textbook')->nullable()->after('notes');
            }
            
            // Add status if missing
            if (!Schema::hasColumn('courses', 'status')) {
                $table->string('status', 20)->default('active')->after('textbook');
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