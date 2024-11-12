<?php

namespace App\Modules\Profile\Presentation\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ChangeCoverPhotoRequest extends FormRequest
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
