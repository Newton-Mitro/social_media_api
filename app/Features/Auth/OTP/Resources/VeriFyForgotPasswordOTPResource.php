<?php
namespace App\Features\Auth\OTP\Resources;

class VeriFyForgotPasswordOTPResource
{
    public function __construct(
        public string $otpValidationToken
    ) {
    }
}
