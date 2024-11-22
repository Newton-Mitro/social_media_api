<?php

namespace App\Modules\Auth\Application\Mappers;

use App\Modules\Auth\Application\DTOs\UserAggregateDTO;
use App\Modules\Auth\Domain\Aggregates\UserAggregate;

class UserAggregateMapper
{
    public static function toDTO(UserAggregate $entity): UserAggregateDTO
    {
        return new UserAggregateDTO(
            id: $entity->getId(),
            name: $entity->getName(),
            email: $entity->getEmail(),
            account_verified: $entity->getEmailVerifiedAt() ? true : false,
            profile: ProfileMapper::toDTO($entity->getProfile()),
        );
    }
}
