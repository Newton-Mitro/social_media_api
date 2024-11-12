<?php

namespace Database\Seeders;

use App\Modules\Auth\Infrastructure\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run()
    {
        User::factory()->count(3)->create();
    }
}
