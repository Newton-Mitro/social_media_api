<?php

namespace App\Modules\Auth\Application\Mappers;

use App\Modules\Auth\Application\Resources\BlacklistedTokenResource;
use App\Modules\Auth\Domain\Entities\BlacklistedTokenEntity;

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
