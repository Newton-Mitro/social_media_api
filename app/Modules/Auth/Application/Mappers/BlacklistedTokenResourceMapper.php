<?php

namespace App\Modules\Auth\Application\Mappers;

use App\Modules\Auth\Application\DTOs\BlacklistedTokenDTO;
use App\Modules\Auth\Domain\Entities\BlacklistedTokenEntity;

class BlacklistedTokenDTOMapper
{
    public static function toDTO(BlacklistedTokenEntity $entity): BlacklistedTokenDTO
    {
        return new BlacklistedTokenDTO(
            id: $entity->getId(),
            token: $entity->getToken(),
        );
    }
}
