<?php

namespace Database\Factories;

use Illuminate\Support\Str;
use App\Modules\Auth\Infrastructure\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use App\Modules\Content\Post\Infrastructure\Models\Post;
use App\Modules\Content\Comment\Infrastructure\Models\Comment;

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
            'id' => Str::uuid(),
            'commentable_id' => $postId,  // Using the random post ID, or null if no posts exist
            'commentable_type' => Post::class,  // Assuming the comment is related to a post
            'user_id' => User::inRandomOrder()->first()->id,  // Randomly assigning a user
            'comment_text' => $this->faker->sentence,  // Random comment text
            'parent_id' => $parentCommentId,  // Set the parent ID if it's a reply
        ];
    }
}
