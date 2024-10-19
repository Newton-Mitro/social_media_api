<?php

namespace App\Modules\Auth\User\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCoverPictureRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'coverPhoto' => 'required|file|mimes:jpeg,jpg,png|max:2048',
        ];
    }
}
