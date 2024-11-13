<?php

namespace App\Modules\Auth\Infrastructure\Repositories;

use App\Modules\Auth\Domain\Entities\UserOtpEntity;
use App\Modules\Auth\Domain\Interfaces\UserOTPRepositoryInterface;
use App\Modules\Auth\Infrastructure\Mappers\UserOtpEntityMapper;
use App\Modules\Auth\Infrastructure\Mappers\UserOtpModelMapper;
use App\Modules\Auth\Infrastructure\Models\UserOtp;
use Illuminate\Support\Facades\DB;

class UserOtpRepositoryInterfaceImpl implements UserOTPRepositoryInterface
{
    public function save(UserOtpEntity $entity): void
    {
        DB::transaction(function () use ($entity) {
            $user = UserOtpModelMapper::toModel($entity);
            $user->save();
        });
    }

    public function findUserOTPByUserId(string $userId): ?UserOtpEntity
    {
        $userOtp = UserOtp::where('user_id', $userId)->first();
        if ($userOtp) {
            return UserOtpEntityMapper::toEntity($userOtp);
        }
        return null;
    }
}