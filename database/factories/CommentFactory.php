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
        $isReply = $this->faker->boolean;  // Randomly decide if this is a reply

        return [
            'commentable_id' => Post::inRandomOrder()->first()->id,  // Assuming comments are for posts
            'commentable_type' => Post::class,  // Assuming commentable type is Post
            'user_id' => User::inRandomOrder()->first()->id,
            'comment_text' => $this->faker->sentence,
            'parent_id' => $isReply ? Comment::inRandomOrder()->first()->id : null, // If it's a reply, set a random parent comment
        ];
    }
}
