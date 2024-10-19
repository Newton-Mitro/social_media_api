<?php
namespace App\Features\Auth\OTP\Resources;

class ForgotPasswordOTPResource
{
    public function __construct(
        public int $otpValidationTime
    ) {
    }
}
