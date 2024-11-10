<?php

namespace App\Modules\Auth\Authentication\Application\Resources;

class VeriFyForgotPasswordOTPResource
{
    public function __construct(
        public string $otpValidationToken
    ) {}
}
