<?php

namespace Database\Factories;

use App\Modules\Auth\User\Models\User;
use App\Modules\Post\Infrastructure\Models\Comment;
use App\Modules\Post\Infrastructure\Models\Like;
use App\Modules\Post\Infrastructure\Models\Post;
use Illuminate\Database\Eloquent\Factories\Factory;

class LikeFactory extends Factory
{
    protected $model = Like::class;

    public function definition()
    {
        return [
            'likable_id' => $this->faker->randomNumber(),
            'likable_type' => $this->faker->randomElement([Post::class, Comment::class]),
            'user_id' => User::inRandomOrder()->first()->id,
        ];
    }
}
