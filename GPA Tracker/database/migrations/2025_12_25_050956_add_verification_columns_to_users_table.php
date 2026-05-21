<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            if (!Schema::hasColumn('users', 'email_verification_token')) {
                $table->string('email_verification_token')->nullable()->after('email');
            }
            if (!Schema::hasColumn('users', 'password_reset_token')) {
                $table->string('password_reset_token')->nullable()->after('email_verification_token');
            }
            if (!Schema::hasColumn('users', 'password_reset_expires')) {
                $table->timestamp('password_reset_expires')->nullable()->after('password_reset_token');
            }
            if (!Schema::hasColumn('users', 'role')) {
                $table->string('role')->default('user')->after('password');
            }
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['email_verification_token', 'password_reset_token', 'password_reset_expires', 'role']);
        });
    }
};