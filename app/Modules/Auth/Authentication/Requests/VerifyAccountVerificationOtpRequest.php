<?php

namespace App\Modules\Auth\Authentication\Requests;

use Illuminate\Foundation\Http\FormRequest;

class VerifyAccountVerificationOtpRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'otp' => 'required|string',
        ];
    }

    public function data()
    {
        return new VerifyAccountVerificationOtpRequestDTO($this);
    }
}
