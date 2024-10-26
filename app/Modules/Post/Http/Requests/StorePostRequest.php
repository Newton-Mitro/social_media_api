<?php

namespace App\Modules\Post\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePostRequest extends FormRequest
{
    public function authorize()
    {
        return true; // Add authorization logic if necessary
    }

    public function rules()
    {
        return [
            'body' => 'required|string',
            'location' => 'nullable|string',
            'privacy_id' => 'required|exists:privacies,id',
            'attachments.*.type' => 'required|in:image,video,link,document',
            'attachments.*.url' => 'required|url',
            'attachments.*.thumbnail_url' => 'nullable|url',
            'attachments.*.description' => 'nullable|string',
            'attachments.*.duration' => 'nullable|integer',
        ];
    }
}
