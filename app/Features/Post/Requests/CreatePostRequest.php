<?php

namespace App\Features\Post\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreatePostRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'body' => 'required|string',
            'privacy_id' => 'required|numeric',
            'attachments.*' => 'file|mimes:jpg,jpeg,png,pdf,mp4|max:2048'
        ];
    }
}
