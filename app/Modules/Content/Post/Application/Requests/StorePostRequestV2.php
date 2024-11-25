<?php

namespace App\Modules\Content\Post\Application\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePostRequestV2 extends FormRequest
{
    public function authorize()
    {
        return true; // Set to true or add authorization logic
    }

    public function rules()
    {
        return [
            'post_text' => 'nullable|string',
            'location' => 'nullable|string',
            'privacy_id' => 'required|string|exists:privacies,id',
            'attachments' => 'nullable|array',
            'attachments.*.mime_type' => 'required_with:attachments|string',
            'attachments.*.file_url' => 'required_with:attachments|url',
            'attachments.*.file_path' => 'required_with:attachments|string',
            'attachments.*.file_name' => 'required_with:attachments|string',
            'attachments.*.thumbnail_url' => 'nullable|url',
            'attachments.*.description' => 'nullable|string',
            'attachments.*.duration' => 'nullable|integer',
        ];
    }

    public function messages()
    {
        return [
            'post_text.required' => 'The post content is required.',
            'privacy_id.required' => 'Privacy setting is required.',
            'privacy_id.exists' => 'The selected privacy setting is invalid.',
            'attachments.*.file_url.url' => 'Each attachment must have a valid URL.',
        ];
    }
}
