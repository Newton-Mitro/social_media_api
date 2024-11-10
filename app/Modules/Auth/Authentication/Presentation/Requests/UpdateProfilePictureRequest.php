<?php

namespace App\Modules\Auth\Authentication\Presentation\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProfilePictureRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'profilePhoto' => 'required|file|mimes:jpeg,jpg,png|max:2048',
        ];
    }
}
