<?php

namespace App\Modules\Follow\Domain\Repositories;

use App\Modules\Follow\Domain\Entities\FollowEntity;
use App\Modules\Friend\Domain\Entities\FriendRequestEntity;

interface FollowRepositoryInterface
{
    public function getAll(int $limit = 10, int $offset = 0): array;
    public function save(FollowEntity $followEntity): void;
    public function findById(string $followId): ?FriendRequestEntity;
    public function delete(string $followId): void;
    public function userFollowingCount(string $userId): int;
    public function userFollowsCount(string $userId): int;
    public function isFollowing(string $userId, string $authUserId = null): bool;
}
