<?php

namespace App\Modules\Post\Domain\Interfaces;

use App\Modules\Auth\Domain\Entities\UserEntity;
use App\Modules\Post\Domain\Aggregates\PostAggregate;
use App\Modules\Post\Domain\Enums\ReactionTypes;

interface PostRepositoryInterface
{
    public function getAll(int $limit = 10, int $offset = 0, ?string $auth_user_id = null): array;
    public function save(PostAggregate $post): void;
    public function findById(string $postId): ?PostAggregate;
    public function delete(string $postId): void;

    public function reactToPost(PostAggregate $postId, UserEntity $userId, ReactionTypes $reactionType);
    public function getReactions();

    public function sharePost(PostAggregate $postId, UserEntity $userId);
    public function getShares();

    public function viewPost(PostAggregate $postId, UserEntity $userId);
    public function getViews();

    public function saveComment();
    public function deleteComment();
    public function getComments();
}
