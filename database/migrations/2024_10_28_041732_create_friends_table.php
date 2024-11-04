<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFriendsTable extends Migration
{
    public function up()
    {
        Schema::create('friends', function (Blueprint $table) {
            $table->id();

            // Foreign UUID keys
            $table->foreignUuid('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreignUuid('friend_id')->references('id')->on('users')->onDelete('cascade');

            $table->timestamp('accepted_at')->nullable(); // Indicates when the friendship was accepted
            $table->timestamps();

            // Unique constraint to prevent duplicate friendships in both directions
            $table->unique(['user_id', 'friend_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('friends');
    }
}
