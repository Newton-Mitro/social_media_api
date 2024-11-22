<?php

namespace App\Modules\Auth\Infrastructure\Repositories;

use App\Modules\Auth\Domain\Aggregates\UserAggregate;
use App\Modules\Auth\Domain\Entities\UserOtpEntity;
use App\Modules\Auth\Domain\Interfaces\AuthRepositoryInterface;
use App\Modules\Auth\Domain\Interfaces\UserOTPRepositoryInterface;
use App\Modules\Auth\Domain\Interfaces\UserRepositoryInterface;
use Illuminate\Support\Facades\DB;

class AuthRepository implements AuthRepositoryInterface
{
    public function __construct(protected UserRepositoryInterface $userRepository, protected UserOTPRepositoryInterface $userOtpRepository,) {}

    public function register(UserAggregate $userAggregate, UserOtpEntity $userOtpEntity): void
    {
        DB::transaction(function () use ($userAggregate, $userOtpEntity) {
            $this->userRepository->save($userAggregate);
            $this->userOtpRepository->save($userOtpEntity);
        });
    }
}
