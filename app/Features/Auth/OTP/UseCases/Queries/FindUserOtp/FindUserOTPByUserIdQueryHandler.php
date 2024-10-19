<?php
namespace App\Features\Auth\OTP\UseCases\Queries\FindUserOtp;

use App\Core\Bus\QueryHandler;
use App\Features\Auth\OTP\Interfaces\UserOTPRepositoryInterface;

class FindUserOTPByUserIdQueryHandler extends QueryHandler
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
