<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Modules\Auth\User\Models\User;

class UserSeeder extends Seeder
{
    public function run()
    {
        User::factory()->count(3)->create();
    }
}
