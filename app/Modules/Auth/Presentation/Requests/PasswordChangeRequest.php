<?php

namespace App\Modules\Auth\Presentation\Requests;

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
            'password' => 'required|min:6|confirmed',
            'old_password' => 'required|min:6',
        ];
    }
}
