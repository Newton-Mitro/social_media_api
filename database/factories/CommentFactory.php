<?php

namespace Database\Factories;

use App\Modules\Auth\Infrastructure\Models\User;
use App\Modules\Post\Infrastructure\Models\Comment;
use App\Modules\Post\Infrastructure\Models\Post;
use Illuminate\Database\Eloquent\Factories\Factory;

class CommentFactory extends Factory
{
    protected $model = Comment::class;

    public function definition()
    {
        return [
            'commentable_id' => Post::inRandomOrder()->first()->id,
            'commentable_type' => Post::class,
            'user_id' => User::inRandomOrder()->first()->id,
            'comment_text' => $this->faker->sentence,
        ];
    }
}
