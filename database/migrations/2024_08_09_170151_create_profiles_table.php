<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('profiles', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('user_id')->constrained('users')->onDelete('cascade');
            $table->enum('sex', ['Male, Female, Others'])->nullable();
            $table->timestamp('dbo')->nullable();
            $table->string('mobile_number')->nullable();
            $table->string('profile_picture', 1024)->nullable();
            $table->string('cover_photo', 1024)->nullable();
            $table->string('bio')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('profiles');
    }
};
