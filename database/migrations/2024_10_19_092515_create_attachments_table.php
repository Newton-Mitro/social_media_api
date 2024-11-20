<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAttachmentsTable extends Migration
{
    public function up()
    {
        Schema::create('attachments', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('post_id')->constrained('posts');
            $table->string('mime_type'); // ['image', 'video', 'link', 'document']
            $table->string('file_url');
            $table->string('file_path')->nullable();
            $table->string('file_name')->nullable();
            $table->string('thumbnail_url')->nullable();
            $table->string('title')->nullable();
            $table->text('description')->nullable();
            $table->integer('duration')->nullable();
            $table->unsignedInteger('comment_count')->default(0);
            $table->unsignedInteger('reaction_count')->default(0);
            $table->unsignedInteger('view_count')->default(0);
            $table->unsignedInteger('share_count')->default(0);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('attachments');
    }
}
