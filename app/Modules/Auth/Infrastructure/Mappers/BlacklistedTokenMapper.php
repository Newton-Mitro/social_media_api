<?php

namespace App\Modules\Auth\Infrastructure\Mappers;

use App\Modules\Auth\Domain\Entities\BlacklistedTokenEntity;
use App\Modules\Auth\Infrastructure\Models\BlacklistedToken;
use DateTimeImmutable;

class BlacklistedTokenMapper
{
    public static function toEntity(BlacklistedToken $model): BlacklistedTokenEntity
    {
        return new BlacklistedTokenEntity(
            id: $model->id,
            token: $model->token,
            createdAt: new DateTimeImmutable($model->created_at),
            updatedAt: new DateTimeImmutable($model->updated_at)
        );
    }

    public static function toModel(BlacklistedTokenEntity $entity): BlacklistedToken
    {
        $model = BlacklistedToken::find($entity->getId()) ?? new BlacklistedToken();
        $model->id = $entity->getId();
        $model->token = $entity->getToken();
        $model->created_at = $entity->getCreatedAt();
        $model->updated_at = $entity->getUpdatedAt();

        return $model;
    }
}
