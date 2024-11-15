<?php

use App\Modules\Auth\Infrastructure\Models\User;
use App\Modules\Follow\Infrastructure\Models\Follow;
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
