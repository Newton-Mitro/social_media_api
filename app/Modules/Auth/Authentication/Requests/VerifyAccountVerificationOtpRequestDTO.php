<?php

namespace App\Modules\Auth\Authentication\Requests;

class VerifyAccountVerificationOtpRequestDTO
{
    public string $otp;

    public function __construct(VerifyAccountVerificationOtpRequest $request)
    {
        $this->otp = $request->input('otp');
    }
}
