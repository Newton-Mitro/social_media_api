<?php

namespace App\Modules\Auth\Infrastructure\Repositories;

use App\Core\Enums\OtpTypes;
use App\Modules\Auth\Domain\Entities\UserOtpEntity;
use App\Modules\Auth\Domain\Interfaces\UserOTPRepositoryInterface;
use App\Modules\Auth\Infrastructure\Mappers\UserOtpMapper;
use App\Modules\Auth\Infrastructure\Models\UserOtp;

class UserOtpRepository implements UserOTPRepositoryInterface
{
    public function findById(string $userId): ?UserOtpEntity
    {
        $userOtp = UserOtp::find($userId);
        if ($userOtp) {
            return UserOtpMapper::toEntity($userOtp);
        }

        return null;
    }

    public function save(UserOtpEntity $entity): void
    {
        $user = UserOtpMapper::toModel($entity);
        $user->save();
    }

    public function findUserOTPByUserIdAndType(string $userId, OtpTypes $type): ?UserOtpEntity
    {
        $userOtp = UserOtp::where('user_id', $userId)
            ->where('type', $type)
            ->first();
        if ($userOtp) {
            return UserOtpMapper::toEntity($userOtp);
        }
        return null;
    }
}
