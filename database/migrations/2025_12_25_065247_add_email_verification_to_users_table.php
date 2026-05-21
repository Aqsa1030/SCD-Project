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
        Schema::table('users', function (Blueprint $table) {
            // 1. Agar 'otp' column galti se reh gaya hai toh usay khatam karein
            if (Schema::hasColumn('users', 'otp')) {
                $table->dropColumn('otp');
            }

            // 2. Token column add karein agar database mein nahi hai
            if (!Schema::hasColumn('users', 'email_verification_token')) {
                $table->string('email_verification_token', 64)->nullable()->after('password');
            }

            // 3. Role column add karein agar database mein nahi hai
            if (!Schema::hasColumn('users', 'role')) {
                $table->string('role')->default('user')->after('email');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Rollback karte waqt columns ko delete karne ke liye
            $table->dropColumn(['email_verification_token', 'role']);
        });
    }
};