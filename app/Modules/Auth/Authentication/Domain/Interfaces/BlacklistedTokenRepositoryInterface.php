<?php

namespace App\Modules\Auth\Authentication\Domain\Interfaces;

use App\Modules\Auth\Authentication\Domain\Entities\BlacklistedTokenModel;


interface BlacklistedTokenRepositoryInterface
{
    public function addTokenToBlackList(BlacklistedTokenModel $model): int;

    public function blacklistedTokenExist(string $token): bool;
}
