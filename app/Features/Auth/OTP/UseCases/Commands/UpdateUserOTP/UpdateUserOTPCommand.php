<?php
namespace App\Features\Auth\OTP\UseCases\Commands\UpdateUserOTP;

use App\Core\Bus\Command;

class UpdateUserOTPCommand extends Command
{
    public function __construct(
        private readonly int $userId,
        private readonly string $email,
        private readonly bool $verificationStatus,
        private readonly string $userName
    ) {
    }

    public function getUserId(): int
    {
        return $this->userId;
    }
    public function getEmail(): string
    {
        return $this->email;
    }
    public function getVerificationStatus(): bool
    {
        return $this->verificationStatus;
    }
    public function getUserName()
    {
        return $this->userName;
    }
}