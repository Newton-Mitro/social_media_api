<?php

namespace App\Modules\Follow\Infrastructure\Mappers;

use App\Modules\Follow\Domain\Entities\FollowEntity;
use App\Modules\Follow\Infrastructure\Models\Follow;
use Illuminate\Support\Collection;

class FollowMapper
{
    public static function toEntity(Follow $followModel): FollowEntity
    {
        $followerData = $followModel->follower ? $followModel->follower() : null;
        $followingData = $followModel->following ? $followModel->following() : null;

        return new FollowEntity(
            followerId: $followModel->follower_id,
            followingId: $followModel->following_id,
            createdAt: $followModel->created_at ? new \DateTimeImmutable($followModel->created_at) : null,
            updatedAt: $followModel->updated_at ? new \DateTimeImmutable($followModel->updated_at) : null,
            follower: $followerData,
            following: $followingData,
            id: $followModel->id,
        );
    }

    public static function toEntityCollection(Collection $followModels): Collection
    {
        return $followModels->map(fn(Follow $follow) => self::toEntity($follow));
    }

    public static function toModel(FollowEntity $followEntity): Follow
    {
        $followModel = Follow::find($followEntity->getId()) ?? new Follow();

        $followModel->id = $followEntity->getId();
        $followModel->follower_id = $followEntity->getFollowerId();
        $followModel->following_id = $followEntity->getFollowingId();
        $followModel->created_at = $followEntity->getCreatedAt();
        $followModel->updated_at = $followEntity->getUpdatedAt();

        return $followModel;
    }
}
