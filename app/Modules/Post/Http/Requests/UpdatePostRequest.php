<?php

namespace App\Modules\Post\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePostRequest extends FormRequest
{
    public function authorize()
    {
        return true; // Add authorization logic if necessary
    }

    public function rules()
    {
        return [
            'body' => 'sometimes|required|string',
            'location' => 'sometimes|nullable|string',
            'privacy_id' => 'sometimes|required|exists:privacies,id',
            'attachments.*.id' => 'nullable|exists:attachments,id',
            'attachments.*.type' => 'nullable|in:image,video,link,document',
            'attachments.*.url' => 'nullable|url',
            'attachments.*.thumbnail_url' => 'nullable|url',
            'attachments.*.description' => 'nullable|string',
            'attachments.*.duration' => 'nullable|integer',
            'deleted_attachments.*' => 'nullable|exists:attachments,id',
        ];
    }
}
