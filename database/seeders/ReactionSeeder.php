<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Modules\Post\Infrastructure\Models\Reaction;

class ReactionSeeder extends Seeder
{
    public function run()
    {
        Reaction::factory()->count(100)->create();
    }
}
