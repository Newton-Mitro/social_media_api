<?php

namespace App\Modules\Follow\Infrastructure\Repositories;

use App\Modules\Auth\Infrastructure\Mappers\UserAggregateMapper;
use App\Modules\Follow\Domain\Entities\FollowEntity;
use App\Modules\Follow\Domain\Repositories\FollowRepositoryInterface;
use App\Modules\Follow\Infrastructure\Mappers\FollowMapper;
use App\Modules\Follow\Infrastructure\Models\Follow;
use Illuminate\Support\Collection;

class FollowRepository implements FollowRepositoryInterface
{
    public function getAll(int $limit = 10, int $offset = 0): Collection
    {
        $follows = Follow::with(['follower', 'following'])
            ->skip($offset)
            ->take($limit)
            ->get();

        return FollowMapper::toEntityCollection($follows);
    }

    public function save(FollowEntity $followEntity): void
    {
        $follow = FollowMapper::toModel($followEntity);
        $follow->save();
    }

    public function findById(string $followId): ?FollowEntity
    {
        $follow = Follow::with(['follower', 'following'])->find($followId);

        return $follow ? FollowMapper::toEntity($follow) : null;
    }

    public function delete(string $followId): bool
    {
        $deleted = Follow::where('id', $followId)->delete();
        // Return true if deletion was successful, otherwise false
        return $deleted > 0;
    }

    public function userFollowingCount(string $userId): int
    {
        return Follow::where('follower_id', $userId)->count();
    }

    public function userFollowsCount(string $userId): int
    {
        return Follow::where('following_id', $userId)->count();
    }

    public function isFollowing(string $followingUserId, string $followerId = null): ?FollowEntity
    {
        $follow = Follow::with(['follower', 'following'])->where('follower_id', $followerId)
            ->where('following_id', $followingUserId)
            ->first();

        return $follow ? FollowMapper::toEntity($follow) : null;
    }

    public function getUserFollowings(string $userId): Collection
    {
        $following = Follow::with(['follower', 'following'])->where('follower_id', $userId)
            ->get()
            ->pluck('following');

        return UserAggregateMapper::toAggregateCollection($following);
    }

    public function getUserFollowers(string $userId): Collection
    {
        $followers = Follow::with(['follower', 'following'])->where('following_id', $userId)
            ->get()
            ->pluck('follower');

        return UserAggregateMapper::toAggregateCollection($followers);
    }
}
