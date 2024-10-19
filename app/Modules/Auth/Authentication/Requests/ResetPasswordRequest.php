<?php

namespace App\Modules\Auth\Authentication\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ResetPasswordRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'email' => 'required|email',
            'password' => 'required|min:6|confirmed',
            'token' => 'required|string'
        ];
    }

    public function data()
    {
        return new ResetPasswordRequestDTO($this);
    }
}
