<?php

namespace Database\Factories;

use App\Modules\Auth\User\Models\User;
use App\Modules\Post\Infrastructure\Models\Post;
use App\Modules\Post\Infrastructure\Models\Comment;
use Illuminate\Database\Eloquent\Factories\Factory;

class CommentFactory extends Factory
{
    protected $model = Comment::class;

    public function definition()
    {
        return [
            'post_id' => Post::inRandomOrder()->first()->id,
            'user_id' => User::inRandomOrder()->first()->id,
            'comment_text' => $this->faker->sentence,
            'timestamp' => $this->faker->dateTime,
        ];
    }
}
