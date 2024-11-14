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
        // Randomly decide if this is a reply or a top-level comment
        $isReply = $this->faker->boolean;

        // Get a random post, ensuring there is at least one post available
        $post = Post::inRandomOrder()->first();
        $postId = $post ? $post->id : null;  // If no posts exist, set postId to null

        // Get a random comment for replies, ensuring there is at least one comment available
        $parentCommentId = null;
        if ($isReply) {
            $parentComment = Comment::inRandomOrder()->first();
            $parentCommentId = $parentComment ? $parentComment->id : null;  // Ensure we don't attempt to assign null
        }

        return [
            'commentable_id' => $postId,  // Using the random post ID, or null if no posts exist
            'commentable_type' => Post::class,  // Assuming the comment is related to a post
            'user_id' => User::inRandomOrder()->first()->id,  // Randomly assigning a user
            'comment_text' => $this->faker->sentence,  // Random comment text
            'parent_id' => $parentCommentId,  // Set the parent ID if it's a reply
        ];
    }
}
