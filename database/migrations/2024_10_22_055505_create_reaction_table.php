<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('reactions', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuidMorphs('reactable'); // Creates reactable_id and reactable_type columns
            $table->foreignUuid('user_id')->constrained('users')->onDelete('cascade');

            // Define 'type' as an ENUM with specific reaction types
            $table->enum('type', ['like', 'love', 'haha', 'wow', 'sad', 'angry'])->index();

            $table->timestamps();

            // Unique constraint to ensure each user can have only one reaction of each type per reactable item
            $table->unique(['user_id', 'reactable_id', 'reactable_type', 'type']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('reactions');
    }
};
