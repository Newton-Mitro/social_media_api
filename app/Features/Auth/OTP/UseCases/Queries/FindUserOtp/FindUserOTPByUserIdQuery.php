<?php
namespace App\Features\Auth\OTP\UseCases\Queries\FindUserOtp;

use App\Core\Bus\Query;

class FindUserOTPByUserIdQuery extends Query
{
    public function __construct(
        private readonly int $userId

    ) {}

    public function getUserId(): int
    {
        return $this->userId;
    }
}
