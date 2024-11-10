<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Modules\Post\Infrastructure\Models\Like;

class LikeSeeder extends Seeder
{
    public function run()
    {
        Like::factory()->count(100)->create();
    }
}
