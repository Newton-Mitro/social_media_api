<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Modules\Content\Infrastructure\Models\Privacy;

class PrivacySeeder extends Seeder
{
    public function run()
    {
        Privacy::insert([
            ['privacy_name' => 'Public'],
            ['privacy_name' => 'Friends'],
            ['privacy_name' => 'Only Me'],
            ['privacy_name' => 'Friends of Friend'],
        ]);
    }
}
