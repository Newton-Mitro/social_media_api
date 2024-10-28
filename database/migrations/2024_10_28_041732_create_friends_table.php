<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('friends', function (Blueprint $table) {
            $table->id();

            // Foreign keys
            $table->foreignUuid('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreignUuid('friend_id')->references('id')->on('users')->onDelete('cascade');

            $table->timestamp('accepted_at')->nullable(); // Indicates when the friendship was accepted
            $table->timestamps();

            // Unique constraint to prevent duplicate friendships
            $table->unique(['user_id', 'friend_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('friends');
    }
};
