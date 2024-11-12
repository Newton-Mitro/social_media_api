<?php

namespace App\Modules\Auth\Domain\Interfaces;

use App\Modules\Auth\Domain\Entities\BlacklistedTokenEntity;


interface BlacklistedTokenRepositoryInterface
{
    public function save(BlacklistedTokenEntity $model): void;
    public function findByToken(string $token): ?BlacklistedTokenEntity;
}
