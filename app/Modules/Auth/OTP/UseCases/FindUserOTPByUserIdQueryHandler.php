<?php

namespace App\Modules\Auth\OTP\UseCases\Queries\FindUserOtp;

use App\Modules\Auth\OTP\Interfaces\UserOTPRepositoryInterface;

class FindUserOTPByUserIdQueryHandler
{
    public function __construct(
        protected readonly UserOTPRepositoryInterface $repository,
    ) {}

    public function handle(FindUserOTPByUserIdQuery $query): ?object
    {
        return $this->repository->findUserOTPByUserId(
            $query->getUserId(),
        );
    }
}
