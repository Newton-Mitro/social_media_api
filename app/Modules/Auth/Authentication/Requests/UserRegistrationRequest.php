<?php

namespace App\Modules\Auth\Authentication\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRegistrationRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => 'required',
            'email' => 'required',
            'password' => 'required|min:6|confirmed',
        ];
    }

    public function data()
    {
        return new UserRegistrationRequestDTO($this);
    }
}
