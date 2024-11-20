<?php

namespace App\Modules\Content\Attachment\Presentation\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreAttachmentRequest extends FormRequest
{

    public function authorize()
    {
        return true; // You can implement authorization logic here if needed
    }

    public function rules()
    {
        return [
            'post_id' => 'required|uuid',
            'mime_type' => 'required|string',
            'file_url' => 'required|url',
            'file_path' => 'nullable|string',
            'file_name' => 'nullable|string',
            'thumbnail_url' => 'nullable|url',
            'title' => 'nullable|string',
            'description' => 'nullable|string',
            'duration' => 'nullable|integer',
        ];
    }
}
