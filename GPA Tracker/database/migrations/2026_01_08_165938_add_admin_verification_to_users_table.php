<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->timestamp('verified_by_admin_at')->nullable()->after('email_verified_at');
            $table->unsignedBigInteger('verified_by_admin_id')->nullable()->after('verified_by_admin_at');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['verified_by_admin_at', 'verified_by_admin_id']);
        });
    }
};