<?php

namespace App\Features\Auth\OTP\Interfaces;

use App\Features\Auth\OTP\BusinessModel\UserOtpModel;

interface UserOTPRepositoryInterface
{
    public function create(UserOtpModel $userOtpModel): ?UserOtpModel;
    public function findUserOTPByUserId(int $userId): ?UserOtpModel;
    public function update(UserOtpModel $userOtpModel): ?UserOtpModel;
}
