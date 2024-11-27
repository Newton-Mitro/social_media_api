<?php

namespace App\Modules\Follow\Domain\Repositories;

use App\Modules\Follow\Domain\Entities\FollowEntity;
use Illuminate\Support\Collection;

interface FollowRepositoryInterface
{
    public function getAll(int $limit = 10, int $offset = 0): Collection;
    public function save(FollowEntity $followEntity): void;
    public function findById(string $followId): ?FollowEntity;
    public function delete(string $followId): bool;
    public function userFollowingCount(string $userId): int;
    public function userFollowsCount(string $userId): int;
    public function isFollowing(string $followingUserId, string $followerId = null): ?FollowEntity;
    public function getUserFollowings(string $userId): Collection;
    public function getUserFollowers(string $userId): Collection;
}
