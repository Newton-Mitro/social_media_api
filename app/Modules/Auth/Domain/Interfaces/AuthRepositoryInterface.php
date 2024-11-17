<?php

namespace App\Modules\Auth\Domain\Interfaces;

use App\Modules\Auth\Domain\Entities\UserEntity;
use App\Modules\Auth\Domain\Entities\UserOtpEntity;


interface AuthRepositoryInterface
{
    public function register(UserEntity $userUserModel, UserOtpEntity $userOtpEntity): void;
}
