<?php

namespace App\Modules\Auth\Authentication\Application\Resources;

class ForgotPasswordOTPResource
{
    public function __construct(
        public int $otpValidationTime
    ) {}
}
