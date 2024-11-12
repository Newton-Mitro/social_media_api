<?php

use App\Modules\Auth\Authentication\Infrastructure\Models\User;
use App\Modules\User\Infrastructure\Models\Follow;
use Illuminate\Database\Eloquent\Factories\Factory;

class FollowFactory extends Factory
{
    protected $model = Follow::class;

    public function definition()
    {
        return [
            'follower_id' => User::inRandomOrder()->first()->id,
            'following_id' => User::inRandomOrder()->first()->id,
        ];
    }
}
