<?php

namespace App\Modules\Auth\OTP\Resources;

class VeriFyForgotPasswordOTPResource
{
    public function __construct(
        public string $otpValidationToken
    ) {}
}
