<?php

namespace App\Modules\Auth\Authentication\Domain\Interfaces;

use App\Modules\Auth\Authentication\Domain\Entities\UserOtpEntity;


interface UserOTPRepositoryInterface
{
    public function create(UserOtpEntity $userOtpModel): ?UserOtpEntity;
    public function findUserOTPByUserId(string $userId): ?UserOtpEntity;
    public function update(UserOtpEntity $userOtpModel): ?UserOtpEntity;
}
