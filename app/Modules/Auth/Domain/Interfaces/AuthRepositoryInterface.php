<?php

namespace App\Modules\Auth\Domain\Interfaces;

use App\Modules\Auth\Domain\Aggregates\UserAggregate;
use App\Modules\Auth\Domain\Entities\UserOtpEntity;


interface AuthRepositoryInterface
{
    public function register(UserAggregate $userAggregate, UserOtpEntity $userOtpEntity): void;
}
