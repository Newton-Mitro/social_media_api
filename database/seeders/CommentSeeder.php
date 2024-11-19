<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Modules\Content\Infrastructure\Models\Comment;

class CommentSeeder extends Seeder
{
    public function run()
    {
        Comment::factory()->count(50)->create();
    }
}
