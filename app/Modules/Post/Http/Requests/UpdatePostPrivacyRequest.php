<?php

namespace App\Features\Post\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePostPrivacyRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'post_id' => 'required|int',
            'privacy_id' => 'required|int'
        ];
    }
}
