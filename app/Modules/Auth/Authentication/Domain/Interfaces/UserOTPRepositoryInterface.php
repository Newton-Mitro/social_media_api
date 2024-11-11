<?php

namespace App\Modules\Auth\Authentication\Domain\Interfaces;

use App\Modules\Auth\Authentication\Domain\Entities\UserOtpEntity;


interface UserOTPRepositoryInterface
{
    public function save(UserOtpEntity $userOtpModel): void;
    public function findUserOTPByUserId(string $userId): ?UserOtpEntity;
}
