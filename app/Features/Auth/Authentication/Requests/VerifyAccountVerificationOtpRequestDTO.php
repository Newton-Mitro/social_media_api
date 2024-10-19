<?php

namespace App\Features\Auth\Authentication\Requests;

class VerifyAccountVerificationOtpRequestDTO
{
    public string $otp;

    public function __construct(VerifyAccountVerificationOtpRequest $request)
    {
        $this->otp = $request->input('otp');
    }
}
