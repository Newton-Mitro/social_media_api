<?php

use App\Modules\Auth\Infrastructure\Models\User;
use App\Modules\Friend\Infrastructure\Models\FriendRequest;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class FriendRequestFactory extends Factory
{
    protected $model = FriendRequest::class;

    public function definition()
    {
        return [
            'id' => Str::uuid(),
            'sender_id' => User::inRandomOrder()->first()->id,
            'receiver_id' => User::inRandomOrder()->first()->id,
            'status' => $this->faker->randomElement(['Pending', 'Accepted']),
        ];
    }
}
