<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Modules\Post\Infrastructure\Models\Comment;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class CommentSeeder extends Seeder
{
    public function run()
    {
        Comment::factory()->count(50)->create();
    }
}
