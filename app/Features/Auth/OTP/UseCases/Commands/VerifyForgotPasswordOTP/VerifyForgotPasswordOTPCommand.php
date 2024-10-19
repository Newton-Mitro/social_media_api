<?php

namespace App\Features\Auth\OTP\UseCases\Commands\VerifyForgotPasswordOTP;

use App\Core\Bus\Command;

class VerifyForgotPasswordOTPCommand extends Command
{
    public function __construct(
        private readonly string $email,
        private readonly string $otp,
    ) {}

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getOtp(): string
    {
        return $this->otp;
    }
}
