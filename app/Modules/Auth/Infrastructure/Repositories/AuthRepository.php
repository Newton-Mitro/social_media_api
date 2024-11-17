<?php

namespace App\Modules\Auth\Infrastructure\Repositories;

use App\Modules\Auth\Domain\Entities\UserEntity;
use App\Modules\Auth\Domain\Entities\UserOtpEntity;
use App\Modules\Auth\Domain\Interfaces\AuthRepositoryInterface;
use App\Modules\Auth\Domain\Interfaces\UserOTPRepositoryInterface;
use App\Modules\Auth\Domain\Interfaces\UserRepositoryInterface;
use App\Modules\Auth\Infrastructure\Mappers\UserModelMapper;
use App\Modules\Auth\Infrastructure\Mappers\UserOtpModelMapper;
use Illuminate\Support\Facades\DB;

class AuthRepository implements AuthRepositoryInterface
{
    public function __construct(protected UserRepositoryInterface $userRepository, protected UserOTPRepositoryInterface $userOtpRepository,) {}

    public function register(UserEntity $userEntity, UserOtpEntity $userOtpEntity): void
    {
        DB::transaction(function () use ($userEntity, $userOtpEntity) {

            $user = UserModelMapper::toModel($userEntity);
            $user->save();

            // $userOtp = UserOtpModelMapper::toModel($userOtpEntity);
            // $userOtp->save();

            // $this->userRepository->save($userEntity);
            // $this->userOtpRepository->save($userOtpEntity);
        });
    }
}
