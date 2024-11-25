<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('shares', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('post_id')->nullable()->constrained('posts')->onDelete('cascade');
            $table->foreignUuid('attachment_id')->nullable()->constrained('attachments')->onDelete('cascade');
            $table->foreignUuid('shared_by')->constrained('users')->onDelete('cascade');
            $table->foreignUuid('shared_to')->constrained('users')->onDelete('cascade');
            $table->text('message')->nullable();
            $table->timestamps();

            $table->unique(['post_id', 'attachment_id', 'shared_by', 'shared_to'], 'unique_shares');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('shares');
    }
};
