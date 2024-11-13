<?php

namespace App\Modules\Auth\Application\DTOs;

use DateTimeImmutable;


class UserOtpDTO
{
    public function __construct(
        public string $id,
        public string $otp,
        public string $userId,
        public DateTimeImmutable $expiresAt,
        public bool $isVerified,
        public string $token,
        public DateTimeImmutable $createdAt,
        public DateTimeImmutable $updatedAt,
    ) {}
}
