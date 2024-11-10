<?php

namespace App\Modules\Auth\Authentication\Presentation\Requests;

use Illuminate\Foundation\Http\FormRequest;

class VerifyForgotPasswordOTPRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'email' => 'required|email',
            'otp' => 'required|string',
        ];
    }

    public function data()
    {
        return new VerifyForgotPasswordOTPRequestDTO($this);
    }
}