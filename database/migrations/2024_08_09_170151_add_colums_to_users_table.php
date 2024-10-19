<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('user_name')->unique();
            $table->string('profile_picture', 1024)->nullable();
            $table->string('cover_photo', 1024)->nullable();
            $table->string('otp')->nullable();
            $table->timestamp('otp_expires_at')->nullable();
            $table->boolean('otp_verified')->default(false);
            $table->timestamp('last_logged_in')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('user_name');
            $table->dropColumn('profile_picture');
            $table->dropColumn('cover_photo');
            $table->dropColumn('otp');
            $table->dropColumn('otp_expires_at');
            $table->dropColumn('otp_verified');
            $table->dropColumn('last_logged_in');
        });
    }
};
