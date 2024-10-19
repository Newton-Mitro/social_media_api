<?php

namespace App\Features\Auth\Authentication\UseCases\Commands\SendEmailVerifyingOTP;

use App\Core\Bus\Command;

class SendEmailVerifyingOTPCommand extends Command
{
    public function __construct(
        private readonly string $email,
    ) {}

    public function getEmail(): string
    {
        return $this->email;
    }
}
