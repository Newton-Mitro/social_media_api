<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePostsTable extends Migration
{
    public function up()
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->id('id');
            $table->text('body');
            $table->unsignedInteger('likes')->default(0);
            $table->unsignedInteger('shares')->default(0);
            $table->string('location');
            $table->foreignId('privacy_id')->constrained('privacies');
            $table->foreignId('user_id')->constrained('users');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('posts');
    }
}
