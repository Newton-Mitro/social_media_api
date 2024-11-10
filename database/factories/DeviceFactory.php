<?php

namespace Database\Factories;

use App\Modules\Auth\Authentication\Infrastructure\Models\Device;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class DeviceFactory extends Factory
{
    protected $model = Device::class;

    public function definition(): array
    {
        return [
            'user_id' => fake()->name(),
            'device_name' => fake()->name(),
            'device_ip' => fake()->ipv4(),
            'device_token' => Str::random(10),
        ];
    }
}
