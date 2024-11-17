<?php

namespace App\Modules\Auth\Infrastructure\Repositories;

use App\Modules\Auth\Domain\Entities\UserEntity;
use App\Modules\Auth\Domain\Entities\UserOtpEntity;
use App\Modules\Auth\Domain\Interfaces\AuthRepositoryInterface;
use App\Modules\Auth\Domain\Interfaces\UserOTPRepositoryInterface;
use App\Modules\Auth\Domain\Interfaces\UserRepositoryInterface;
use Illuminate\Support\Facades\DB;

class AuthRepository implements AuthRepositoryInterface
{
    public function __construct(protected UserRepositoryInterface $userRepository, protected UserOTPRepositoryInterface $userOtpRepository,) {}

    public function register(UserEntity $userEntity, UserOtpEntity $userOtpEntity): void
    {
        DB::transaction(function () use ($userEntity, $userOtpEntity) {
            $this->userRepository->save($userEntity);
            $this->userOtpRepository->save($userOtpEntity);
        });
    }
}
