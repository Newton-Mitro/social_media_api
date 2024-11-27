<?php

namespace App\Modules\Follow\Domain\Repositories;

use App\Modules\Follow\Domain\Entities\FollowEntity;
use Illuminate\Support\Collection;

interface FollowRepositoryInterface
{
    public function getAll(int $limit = 10, int $offset = 0): Collection;
    public function save(FollowEntity $followEntity): void;
    public function findById(string $followId): ?FollowEntity;
    public function delete(string $followId): void;
    public function userFollowingCount(string $userId): int;
    public function userFollowsCount(string $userId): int;
    public function isFollowing(string $userId, string $authUserId = null): ?FollowEntity;
}
