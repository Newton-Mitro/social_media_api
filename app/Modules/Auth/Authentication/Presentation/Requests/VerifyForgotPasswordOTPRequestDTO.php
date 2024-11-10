<?php

namespace App\Modules\Auth\Authentication\Presentation\Requests;

use Illuminate\Foundation\Http\FormRequest;

class VerifyForgotPasswordOTPRequestDTO extends FormRequest
{
    public string $email;

    public string $otp;

    public function __construct(VerifyForgotPasswordOTPRequest $request)
    {
        $this->email = $request->input('email');
        $this->otp = $request->input('otp');
    }
}
