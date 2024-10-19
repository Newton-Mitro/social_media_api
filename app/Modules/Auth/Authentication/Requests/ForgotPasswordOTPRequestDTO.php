<?php

namespace App\Modules\Auth\Authentication\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ForgotPasswordOTPRequestDTO extends FormRequest
{
    public string $email;

    public function __construct(ForgotPasswordOTPRequest $request)
    {
        $this->email = $request->input('email');
    }
}
