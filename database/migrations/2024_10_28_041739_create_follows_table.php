<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('follows', function (Blueprint $table) {
            $table->uuid('id')->primary();

            // Foreign keys
            $table->foreignUuid('follower_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreignUuid('following_id')->references('id')->on('users')->onDelete('cascade');

            $table->timestamps();

            // Unique constraint to prevent duplicate follows
            $table->unique(['follower_id', 'following_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('follows');
    }
};
