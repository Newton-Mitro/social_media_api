<?php

namespace App\Modules\Auth\Authentication\Infrastructure\Repositories;

use App\Modules\Auth\Authentication\Domain\Entities\BlacklistedTokenEntity;
use App\Modules\Auth\Authentication\Domain\Interfaces\BlacklistedTokenRepositoryInterface;
use App\Modules\Auth\Authentication\Infrastructure\Mappers\BlacklistedTokenEntityMapper;
use App\Modules\Auth\Authentication\Infrastructure\Mappers\BlacklistedTokenModelMapper;
use App\Modules\Auth\Authentication\Infrastructure\Models\BlacklistedToken;
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
