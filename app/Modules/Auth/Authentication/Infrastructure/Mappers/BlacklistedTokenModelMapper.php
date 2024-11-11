<?php

namespace App\Modules\Auth\Authentication\Infrastructure\Mappers;

use App\Modules\Auth\Authentication\Domain\Entities\BlacklistedTokenEntity;
use App\Modules\Auth\Authentication\Infrastructure\Models\BlacklistedToken;

class BlacklistedTokenModelMapper
{
    public static function toModel(BlacklistedTokenEntity $entity): BlacklistedToken
    {
        $user = BlacklistedToken::find($entity->getId()) ?? new BlacklistedToken();
        $user->token = $entity->getToken();
        $user->created_at = $entity->getCreatedAt();
        $user->updated_at = $entity->getUpdatedAt();

        return $user;
    }
}
