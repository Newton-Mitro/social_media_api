<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('user_otps', function (Blueprint $table) {
            $table->id('id')->primary();
            $table->string('otp');
            $table->timestamp('expires_at');
            $table->boolean('is_verified')->default(false);
            $table->foreignUuid('user_id')->references('id')->on('users');
            $table->string('token')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('user_otps');
    }
};
