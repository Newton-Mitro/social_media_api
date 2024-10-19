<?php

namespace App\Features\Auth\Authentication\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PasswordChangeRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            // 'email' => 'required',
            'password' => 'required|min:6|confirmed',
            'old_password' => 'required|min:6|confirmed',
        ];
    }

    public function data()
    {
        return new PasswordChangeRequestDTO($this);
    }
}
