<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCommentsTable extends Migration
{
    public function up()
    {
        Schema::create('comments', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuidMorphs('commentable'); // Creates commentable_id and commentable_type columns
            $table->foreignUuid('user_id')->constrained('users')->onDelete('cascade');
            $table->text('comment_text');
            $table->uuid('parent_id')->nullable();  // Add parent_id for replies, can be null for top-level comments
            $table->foreign('parent_id')->references('id')->on('comments')->onDelete('cascade'); // Cascade delete for parent comments
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('comments');
    }
}
