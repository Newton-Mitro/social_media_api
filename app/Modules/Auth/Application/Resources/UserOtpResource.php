<?php

namespace App\Modules\Auth\Application\Resources;

use DateTimeImmutable;


class UserOtpResource
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
