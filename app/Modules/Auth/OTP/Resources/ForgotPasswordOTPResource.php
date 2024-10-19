<?php

namespace App\Modules\Auth\OTP\Resources;

class ForgotPasswordOTPResource
{
    public function __construct(
        public int $otpValidationTime
    ) {}
}
