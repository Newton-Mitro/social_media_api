<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Modules\Post\Infrastructure\Models\Share;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ShareSeeder extends Seeder
{
    public function run()
    {
        Share::factory()->count(50)->create();
    }
}
