<?php

namespace App\Modules\Follow\Application\Mappers;

use App\Modules\Auth\Application\Mappers\UserAggregateMapper;
use App\Modules\Follow\Application\DTOs\FollowDTO;
use App\Modules\Follow\Domain\Entities\FollowEntity;
use Illuminate\Support\Collection;

class FollowMapper
{
    public static function toDTO(FollowEntity $followEntity): FollowDTO
    {
        return new FollowDTO(
            $followEntity->getId(),
            $followEntity->getFollowerId(),
            $followEntity->getFollowingId(),
            $followEntity->getFollower() ? UserAggregateMapper::toDTO($followEntity->getFollower()) : null,
            $followEntity->getFollowing() ? UserAggregateMapper::toDTO($followEntity->getFollowing()) : null,
            $followEntity->getCreatedAt()?->format(\DateTimeImmutable::ATOM),
            $followEntity->getUpdatedAt()?->format(\DateTimeImmutable::ATOM),
        );
    }

    public static function toDTOCollection(Collection $followEntities): Collection
    {
        return $followEntities->map(fn(FollowEntity $followEntity) => self::toDTO($followEntity));
    }
}
