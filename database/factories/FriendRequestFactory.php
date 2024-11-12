<?php

use App\Modules\Auth\Authentication\Infrastructure\Models\User;
use App\Modules\User\Infrastructure\Models\FriendRequest;
use Illuminate\Database\Eloquent\Factories\Factory;

class FriendRequestFactory extends Factory
{
    protected $model = FriendRequest::class;

    public function definition()
    {
        return [
            'sender_id' => User::inRandomOrder()->first()->id,
            'receiver_id' => User::inRandomOrder()->first()->id,
            'status' => $this->faker->randomElement(['pending', 'accepted', 'rejected']),
        ];
    }
}
