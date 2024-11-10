<?php

namespace App\Modules\Auth\Authentication\Domain\Interfaces;

use App\Modules\Auth\Authentication\Domain\Entities\UserOtpModel;


interface UserOTPRepositoryInterface
{
    public function create(UserOtpModel $userOtpModel): ?UserOtpModel;
    public function findUserOTPByUserId(string $userId): ?UserOtpModel;
    public function update(UserOtpModel $userOtpModel): ?UserOtpModel;
}
