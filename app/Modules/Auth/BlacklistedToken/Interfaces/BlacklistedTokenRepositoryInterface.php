<?php

namespace App\Modules\Auth\BlacklistedToken\Interfaces;

use App\Modules\Auth\BlacklistedToken\BusinessModels\BlacklistedTokenModel;

interface BlacklistedTokenRepositoryInterface
{
    public function addTokenToBlackList(BlacklistedTokenModel $model): int;

    public function blacklistedTokenExist(string $token): bool;
}
