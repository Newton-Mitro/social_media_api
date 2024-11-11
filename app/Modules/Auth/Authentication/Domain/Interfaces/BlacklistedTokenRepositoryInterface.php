<?php

namespace App\Modules\Auth\Authentication\Domain\Interfaces;

use App\Modules\Auth\Authentication\Domain\Entities\BlacklistedTokenEntity;


interface BlacklistedTokenRepositoryInterface
{
    public function save(BlacklistedTokenEntity $model): void;
    public function findByToken(string $token): ?BlacklistedTokenEntity;
}
