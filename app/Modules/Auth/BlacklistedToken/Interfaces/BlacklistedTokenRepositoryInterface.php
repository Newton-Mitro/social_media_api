<?php

namespace App\Features\Auth\BlacklistedToken\Interfaces;

use App\Features\Auth\BlacklistedToken\BusinessModels\BlacklistedTokenModel;

interface BlacklistedTokenRepositoryInterface
{
    public function addTokenToBlackList(BlacklistedTokenModel $model): int;

    public function blacklistedTokenExist(string $token): bool;
}
