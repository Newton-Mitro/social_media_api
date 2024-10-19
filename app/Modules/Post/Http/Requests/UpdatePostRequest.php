<?php

namespace App\Modules\Post\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePostRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'post_id' => 'required|int',
            'body' => 'required|string',
            'existing_content_url' => 'string',
            'privacy_id' => 'required|numeric',
            'attachments.*' => 'file|mimes:jpg,jpeg,png,pdf,mp4|max:2048|sometimes'
        ];
    }
}
