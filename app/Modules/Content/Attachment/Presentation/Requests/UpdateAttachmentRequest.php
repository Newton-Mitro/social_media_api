<?php

namespace App\Modules\Content\Attachment\Presentation\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateAttachmentRequest extends FormRequest
{
    public function authorize()
    {
        return true; // You can implement authorization logic here if needed
    }

    public function rules()
    {
        return [
            'mime_type' => 'nullable|string',
            'file_url' => 'nullable|url',
            'file_path' => 'nullable|string',
            'file_name' => 'nullable|string',
            'thumbnail_url' => 'nullable|url',
            'title' => 'nullable|string',
            'description' => 'nullable|string',
            'duration' => 'nullable|integer',
        ];
    }
}
