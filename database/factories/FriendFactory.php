<?php

use App\Modules\Auth\Authentication\Infrastructure\Models\User;
use App\Modules\User\Infrastructure\Models\Friend;
use Illuminate\Database\Eloquent\Factories\Factory;

class FriendFactory extends Factory
{
    protected $model = Friend::class;

    public function definition()
    {
        return [
            'user_id' => User::inRandomOrder()->first()->id,
            'friend_id' => User::inRandomOrder()->first()->id,
            'accepted_at' => $this->faker->boolean(70) ? $this->faker->dateTimeThisYear : null,
        ];
    }
}
