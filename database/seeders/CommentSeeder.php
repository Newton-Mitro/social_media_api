<?php

namespace Database\Seeders;

use App\Modules\Content\Comment\Infrastructure\Models\Comment;
use Illuminate\Database\Seeder;

class CommentSeeder extends Seeder
{
    public function run()
    {
        Comment::factory()->count(50)->create();
    }
}
