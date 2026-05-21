<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('courses', function (Blueprint $table) {
            // Drop old columns if they exist
            if (Schema::hasColumn('courses', 'course_code')) {
                $table->dropColumn('course_code');
            }
            
            if (Schema::hasColumn('courses', 'course_name')) {
                $table->dropColumn('course_name');
            }
            
            if (Schema::hasColumn('courses', 'credit_hours')) {
                $table->dropColumn('credit_hours');
            }
        });
        
        // Ensure new columns exist
        Schema::table('courses', function (Blueprint $table) {
            if (!Schema::hasColumn('courses', 'code')) {
                $table->string('code', 50)->nullable();
            }
            
            if (!Schema::hasColumn('courses', 'name')) {
                $table->string('name')->nullable();
            }
            
            if (!Schema::hasColumn('courses', 'credits')) {
                $table->integer('credits')->default(3);
            }
        });
    }

    public function down(): void
    {
        Schema::table('courses', function (Blueprint $table) {
            if (Schema::hasColumn('courses', 'code')) {
                $table->dropColumn('code');
            }
            if (Schema::hasColumn('courses', 'name')) {
                $table->dropColumn('name');
            }
            if (Schema::hasColumn('courses', 'credits')) {
                $table->dropColumn('credits');
            }
        });
    }
};