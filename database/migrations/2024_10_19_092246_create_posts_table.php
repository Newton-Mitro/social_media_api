<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePostsTable extends Migration
{
    public function up()
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->text('post_text')->nullable();
            $table->unsignedInteger('reaction_count')->default(0);
            $table->unsignedInteger('share_count')->default(0);
            $table->unsignedInteger('view_count')->default(0);
            $table->unsignedInteger('comment_count')->default(0);
            $table->string('location')->nullable();
            $table->string('privacy_id'); // Ensure this matches the type of `id` in `privacies`
            $table->foreign('privacy_id')->references('id')->on('privacies')->onDelete('cascade');
            $table->foreignUuid('user_id')->constrained('users');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('posts');
    }
}
