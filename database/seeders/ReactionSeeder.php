<?php

namespace Database\Seeders;

use App\Modules\Content\Reaction\Infrastructure\Models\Reaction;
use Illuminate\Database\Seeder;

class ReactionSeeder extends Seeder
{
    public function run()
    {
        Reaction::factory()->count(100)->create();
    }
}
