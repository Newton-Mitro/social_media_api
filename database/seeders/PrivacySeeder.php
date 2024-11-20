<?php

namespace Database\Seeders;

use App\Modules\Content\Privacy\Infrastructure\Models\Privacy;
use Illuminate\Database\Seeder;

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
