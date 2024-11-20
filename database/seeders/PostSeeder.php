<?php

namespace Database\Seeders;

use App\Modules\Content\Post\Infrastructure\Models\Post;
use Illuminate\Database\Seeder;

class PostSeeder extends Seeder
{
    public function run()
    {
        Post::factory()->count(20)->create();
    }
}
