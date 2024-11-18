<?php

namespace App\Modules\Post\Presentation\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePostRequest extends FormRequest
{
    public function authorize()
    {
        return true; // Modify this to add authorization logic if necessary
    }

    public function rules()
    {
        return [
            'body' => 'required|string|max:1000', // Max length to prevent overly long posts
            'location' => 'nullable|string|max:255', // Max length for location
            'privacy_id' => 'required|exists:privacies,id', // Ensure the privacy ID exists in the privacies table
            'attachments' => 'array', // Ensure attachments is an array
            'attachments.*.type' => 'required|in:image,video,link,document', // Attachment type must be one of the specified values
            'attachments.*.url' => 'required|url|max:2048', // Added max length for URL
            'attachments.*.path' => 'required|string|max:255', // Added path validation
            'attachments.*.file_name' => 'required|string|max:255', // Added file_name validation
            'attachments.*.thumbnail_url' => 'nullable|url|max:2048', // Added max length for thumbnail URL
            'attachments.*.description' => 'nullable|string|max:500', // Added max length for description
            'attachments.*.duration' => 'nullable|integer|min:0', // Ensure duration is a non-negative integer
        ];
    }

    // Optional: Custom messages for validation errors
    public function messages()
    {
        return [
            'body.required' => 'The post body is required.',
            'body.max' => 'The post body may not be greater than 1000 characters.',
            'location.max' => 'The location may not be greater than 255 characters.',
            'privacy_id.required' => 'The privacy ID is required.',
            'privacy_id.exists' => 'The selected privacy ID is invalid.',
            'attachments.array' => 'Attachments must be an array.',
            'attachments.*.type.required' => 'The attachment type is required.',
            'attachments.*.type.in' => 'The attachment type must be one of the following: image, video, link, document.',
            'attachments.*.url.required' => 'The attachment URL is required.',
            'attachments.*.url.url' => 'The attachment URL must be a valid URL.',
            'attachments.*.url.max' => 'The attachment URL may not be greater than 2048 characters.',
            'attachments.*.path.required' => 'The attachment path is required.',
            'attachments.*.path.string' => 'The attachment path must be a string.',
            'attachments.*.path.max' => 'The attachment path may not be greater than 255 characters.',
            'attachments.*.file_name.required' => 'The file name is required.',
            'attachments.*.file_name.string' => 'The file name must be a string.',
            'attachments.*.file_name.max' => 'The file name may not be greater than 255 characters.',
            'attachments.*.thumbnail_url.url' => 'The thumbnail URL must be a valid URL.',
            'attachments.*.thumbnail_url.max' => 'The thumbnail URL may not be greater than 2048 characters.',
            'attachments.*.description.max' => 'The description may not be greater than 500 characters.',
            'attachments.*.duration.integer' => 'The duration must be an integer.',
            'attachments.*.duration.min' => 'The duration must be at least 0.',
        ];
    }
}
