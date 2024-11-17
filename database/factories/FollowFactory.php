<?php

use App\Modules\Auth\Infrastructure\Models\User;
use App\Modules\Follow\Infrastructure\Models\Follow;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class FollowFactory extends Factory
{
    protected $model = Follow::class;

    public function definition()
    {
        return [
            'id' => Str::uuid(),
            'follower_id' => User::inRandomOrder()->first()->id,
            'following_id' => User::inRandomOrder()->first()->id,
        ];
    }
}
