<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Modules\Post\Infrastructure\Models\Post;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class PostSeeder extends Seeder
{
    public function run()
    {
        Post::factory()->count(20)->create();
    }
}
