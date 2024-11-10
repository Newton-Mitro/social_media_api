<?php

namespace App\Modules\Auth\Authentication\Presentation\Requests;

class VerifyAccountVerificationOtpRequestDTO
{
    public string $otp;

    public function __construct(VerifyAccountVerificationOtpRequest $request)
    {
        $this->otp = $request->input('otp');
    }
}
