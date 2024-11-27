<?php

namespace App\Modules\Follow\Application\Mappers;

use App\Modules\Follow\Application\DTOs\FollowDTO;
use App\Modules\Follow\Domain\Entities\FollowEntity;
use DateTimeImmutable;


class FollowMapper
{
    public static function toDTO(FollowEntity $followEntity): FollowDTO
    {
        return new FollowDTO(
            $followEntity->getId(),
            $followEntity->getFollowerId(),
            $followEntity->getFollowingId(),
            $followEntity->getFollower(),
            $followEntity->getFollowing(),
            $followEntity->getCreatedAt()?->format(DateTimeImmutable::ATOM),
            $followEntity->getUpdatedAt()?->format(DateTimeImmutable::ATOM),
        );
    }
}
