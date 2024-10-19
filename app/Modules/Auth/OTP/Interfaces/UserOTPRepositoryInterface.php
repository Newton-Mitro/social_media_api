<?php

namespace App\Modules\Auth\OTP\Interfaces;

use App\Modules\Auth\OTP\BusinessModel\UserOtpModel;

interface UserOTPRepositoryInterface
{
    public function create(UserOtpModel $userOtpModel): ?UserOtpModel;
    public function findUserOTPByUserId(int $userId): ?UserOtpModel;
    public function update(UserOtpModel $userOtpModel): ?UserOtpModel;
}
