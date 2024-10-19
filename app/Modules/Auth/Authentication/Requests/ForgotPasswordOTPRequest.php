<?php

namespace App\Features\Auth\Authentication\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ForgotPasswordOTPRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'email' => 'required|email',
        ];
    }

    public function data()
    {
        return new ForgotPasswordOTPRequestDTO($this);
    }
}
