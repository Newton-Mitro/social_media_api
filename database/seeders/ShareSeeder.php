<?php

namespace Database\Seeders;

use App\Modules\Content\Share\Infrastructure\Models\Share;
use Illuminate\Database\Seeder;

class ShareSeeder extends Seeder
{
    public function run()
    {
        Share::factory()->count(50)->create();
    }
}
