<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Modules\Content\Infrastructure\Models\Post;

class PostSeeder extends Seeder
{
    public function run()
    {
        Post::factory()->count(20)->create();
    }
}
