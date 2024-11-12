<?php

namespace App\Modules\Auth\Infrastructure\Mappers;

use App\Modules\Auth\Domain\Entities\BlacklistedTokenEntity;
use App\Modules\Auth\Infrastructure\Models\BlacklistedToken;
use DateTimeImmutable;

class BlacklistedTokenEntityMapper
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
}
