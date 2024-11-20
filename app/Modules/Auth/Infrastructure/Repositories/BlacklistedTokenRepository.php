<?php

namespace App\Modules\Auth\Infrastructure\Repositories;

use App\Modules\Auth\Domain\Entities\BlacklistedTokenEntity;
use App\Modules\Auth\Domain\Interfaces\BlacklistedTokenRepositoryInterface;
use App\Modules\Auth\Infrastructure\Mappers\BlacklistedTokenMapper;
use App\Modules\Auth\Infrastructure\Models\BlacklistedToken;

class BlacklistedTokenRepository implements BlacklistedTokenRepositoryInterface
{
    public function save(BlacklistedTokenEntity $entity): void
    {
        $blacklistedToken = BlacklistedTokenMapper::toModel($entity);
        $blacklistedToken->save();
    }

    public function findByToken(string $token): ?BlacklistedTokenEntity
    {
        $blacklistedToken =  BlacklistedToken::where('token', $token)->first();
        if (!$blacklistedToken) {
            return null;
        }
        return BlacklistedTokenMapper::toEntity($blacklistedToken);
    }
}
