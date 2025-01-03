<?php

namespace App\Modules\Auth\Application\DTOs;

use App\Core\Enums\OtpTypes;
use DateTimeImmutable;


class UserOtpDTO
{
    public function __construct(
        public string $id,
        public string $userId,
        public OtpTypes $type,
        public DateTimeImmutable $expiresAt,
        public bool $isVerified,
        public string $otp,
        public string $token,
        public DateTimeImmutable $createdAt,
        public DateTimeImmutable $updatedAt,
    ) {}
}
