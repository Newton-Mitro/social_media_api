<?php

namespace App\Modules\Auth\Domain\Interfaces;

use App\Modules\Auth\Domain\Entities\UserOtpEntity;


interface UserOTPRepositoryInterface
{
    public function save(UserOtpEntity $userOtpModel): void;
    public function findUserOTPByUserIdAndType(string $userId, string $type): ?UserOtpEntity;
}
