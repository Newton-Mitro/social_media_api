<?php

namespace App\Modules\Auth\Infrastructure\Repositories;

use App\Modules\Auth\Domain\Entities\BlacklistedTokenEntity;
use App\Modules\Auth\Domain\Interfaces\BlacklistedTokenRepositoryInterface;
use App\Modules\Auth\Infrastructure\Mappers\BlacklistedTokenEntityMapper;
use App\Modules\Auth\Infrastructure\Mappers\BlacklistedTokenModelMapper;
use App\Modules\Auth\Infrastructure\Models\BlacklistedToken;
use Illuminate\Support\Facades\DB;

class BlacklistedTokenRepositoryImpl implements BlacklistedTokenRepositoryInterface
{
    public function save(BlacklistedTokenEntity $entity): void
    {
        DB::transaction(function () use ($entity) {
            $blacklistedToken = BlacklistedTokenModelMapper::toModel($entity);
            $blacklistedToken->save();
        });
    }

    public function findByToken(string $token): ?BlacklistedTokenEntity
    {
        $blacklistedToken =  BlacklistedToken::where('token', $token)->first();
        if (!$blacklistedToken) {
            return null;
        }
        return BlacklistedTokenEntityMapper::toEntity($blacklistedToken);
    }
}
