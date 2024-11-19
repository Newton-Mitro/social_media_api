<?php

namespace App\Modules\Content\Comment\Infrastructure\Repositories;

use App\Modules\Content\Post\Domain\Aggregates\PostAggregate;
use App\Modules\Content\Comment\Domain\Entities\CommentEntity;
use App\Modules\Content\Comment\Infrastructure\Models\Comment;



class CommentRepository
{
    /**
     * Add a new CommentEntity to the post.
     */
    public function addComment(PostAggregate $post, CommentEntity $commentEntity): void
    {
        $commentEntity = new Comment();
        $commentEntity->post_id = $post->getId();
        $commentEntity->author_id = $commentEntity->getAuthorId();
        $commentEntity->content = $commentEntity->getContent();
        $commentEntity->save();
    }

    /**
     * Remove a CommentEntity from the post.
     */
    public function removeComment(PostAggregate $post, CommentEntity $commentEntity): void
    {
        Comment::where('post_id', $post->getId())
            ->where('id', $commentEntity->getId())
            ->delete();
    }

    /**
     * Update an existing CommentEntity for a post.
     */
    public function updateComment(PostAggregate $post, CommentEntity $commentEntity): void
    {
        $commentEntity = Comment::find($commentEntity->getId());

        if ($commentEntity && $commentEntity->post_id === $post->getId()) {
            $commentEntity->author_id = $commentEntity->getAuthorId();
            $commentEntity->content = $commentEntity->getContent();
            $commentEntity->save();
        }
    }
}
