<?php

namespace App\Modules\Auth\Authentication\Application\Mappers;

use App\Modules\Auth\Authentication\Application\Resources\BlacklistedTokenResource;
use App\Modules\Auth\Authentication\Domain\Entities\BlacklistedTokenEntity;

class BlacklistedTokenResourceMapper
{
    public static function toResource(BlacklistedTokenEntity $entity): BlacklistedTokenResource
    {
        return new BlacklistedTokenResource(
            id: $entity->getId(),
            token: $entity->getToken(),
        );
    }
}
