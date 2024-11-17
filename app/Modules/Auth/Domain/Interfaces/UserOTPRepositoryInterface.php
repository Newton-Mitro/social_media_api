<?php

namespace App\Modules\Auth\Domain\Interfaces;

use App\Core\Enums\OtpTypes;
use App\Modules\Auth\Domain\Entities\UserOtpEntity;


interface UserOTPRepositoryInterface
{
    public function save(UserOtpEntity $userOtpModel): void;
    public function findUserOTPByUserIdAndType(string $userId, OtpTypes $type): ?UserOtpEntity;
}
