<?php

namespace App\Modules\Content\Post\Application\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePostRequestV2 extends FormRequest
{
    public function authorize()
    {
        return true; // Add authorization logic if necessary
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
            'deleted_attachments' => 'nullable|array',
            'deleted_attachments.*' => 'string|exists:attachments,id', // Validate attachment IDs exist
        ];
    }

    public function messages()
    {
        return [
            'post_text.required' => 'Post content is required.',
            'privacy_id.exists' => 'The selected privacy setting is invalid.',
            'attachments.*.file_url.url' => 'Each attachment must have a valid URL.',
            'deleted_attachments.*.exists' => 'The specified attachment does not exist.',
        ];
    }
}
