<?php
namespace App\Features\Auth\OTP\UseCases\Commands\CreateUserOTP;

use App\Core\Bus\Command;

class CreateUserOTPCommand extends Command
{
    public function __construct(
        private readonly int $userId,
        private readonly string $email,
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
    public function getUserName()
    {
        return $this->userName;
    }
}