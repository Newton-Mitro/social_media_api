<?php

namespace App\Modules\Post\Domain\Interfaces;

use App\Modules\Post\Domain\Entities\CommentEntity;
use App\Modules\Post\Domain\Entities\PostAggregate;
use Illuminate\Support\Collection;

interface PostRepositoryInterface
{
    public function all($perPage): Collection;
    public function save(PostAggregate $post): void;
    public function findById(string $postId): ?PostAggregate;
    public function deleteById(string $postId): void;

    // public function reactToPost($postId, $userId, $reactionType); // update count, create reaction entry
    // public function sharePost($postId, $userId); // update count, create post, create share entry
    // public function viewPost($postId, $userId); // update count, create view entry

    public function addComment(PostAggregate $post, CommentEntity $comment): void;
    public function removeComment(PostAggregate $post, CommentEntity $comment): void;
    public function updateComment(PostAggregate $post, CommentEntity $comment): void;
    public function saveComments(PostAggregate $post, Collection $comments): void;
}
