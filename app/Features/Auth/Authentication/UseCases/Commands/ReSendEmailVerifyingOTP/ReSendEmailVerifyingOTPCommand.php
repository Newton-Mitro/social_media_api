<?php

namespace App\Features\Auth\Authentication\UseCases\Commands\ReSendEmailVerifyingOTP;

use App\Core\Bus\Command;

class ReSendEmailVerifyingOTPCommand extends Command
{
    public function __construct(
        private readonly string $email,
    ) {}

    public function getEmail(): string
    {
        return $this->email;
    }
}
