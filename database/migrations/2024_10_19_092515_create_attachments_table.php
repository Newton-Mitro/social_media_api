<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAttachmentsTable extends Migration
{
    public function up()
    {
        Schema::create('attachments', function (Blueprint $table) {
            $table->id('id');
            $table->foreignId('post_id')->constrained('posts');
            $table->enum('type', ['image', 'video', 'link', 'document']);
            $table->string('url');
            $table->string('thumbnail_url')->nullable();
            $table->text('description')->nullable();
            $table->integer('duration')->nullable();
            $table->unsignedInteger('likes')->default(0);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('attachments');
    }
}
