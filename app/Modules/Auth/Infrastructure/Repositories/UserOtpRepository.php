<?php

namespace App\Modules\Auth\Infrastructure\Repositories;

use App\Core\Enums\OtpTypes;
use App\Modules\Auth\Domain\Entities\UserOtpEntity;
use App\Modules\Auth\Domain\Interfaces\UserOTPRepositoryInterface;
use App\Modules\Auth\Infrastructure\Mappers\UserOtpEntityMapper;
use App\Modules\Auth\Infrastructure\Mappers\UserOtpModelMapper;
use App\Modules\Auth\Infrastructure\Models\UserOtp;

class UserOtpRepository implements UserOTPRepositoryInterface
{
    public function findById(string $userId): ?UserOtpEntity
    {
        $userOtp = UserOtp::find($userId);
        if ($userOtp) {
            return UserOtpEntityMapper::toEntity($userOtp);
        }

        return null;
    }

    public function save(UserOtpEntity $entity): void
    {
        $user = UserOtpModelMapper::toModel($entity);
        $user->save();
    }

    public function findUserOTPByUserIdAndType(string $userId, OtpTypes $type): ?UserOtpEntity
    {
        $userOtp = UserOtp::where('user_id', $userId)
            ->where('type', $type)
            ->first();
        if ($userOtp) {
            return UserOtpEntityMapper::toEntity($userOtp);
        }
        return null;
    }
}
