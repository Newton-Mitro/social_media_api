<?php

namespace App\Modules\Auth\Authentication\Domain\Interfaces;

use App\Modules\Auth\Authentication\Domain\Entities\BlacklistedTokenEntity;


interface BlacklistedTokenRepositoryInterface
{
    public function addTokenToBlackList(BlacklistedTokenEntity $model): int;

    public function blacklistedTokenExist(string $token): bool;
}
