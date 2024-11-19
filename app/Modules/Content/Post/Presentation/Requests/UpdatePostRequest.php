<?php

namespace App\Modules\Content\Post\Presentation\Requests;

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
            'body' => 'sometimes|required|string|max:1000', // Added max length for body
            'location' => 'sometimes|nullable|string|max:255', // Added max length for location
            'privacy_id' => 'sometimes|required|exists:privacies,id', // Ensure the privacy ID exists in the privacies table
            'attachments' => 'sometimes|array', // Ensure attachments is an array
            'attachments.*.id' => 'nullable|exists:attachments,id', // Validate existing attachment IDs
            'attachments.*.type' => 'nullable|in:image,video,link,document', // Validate attachment type
            'attachments.*.url' => 'nullable|url|max:2048', // Validate URL with max length
            'attachments.*.path' => 'nullable|string|max:255', // Added validation for path
            'attachments.*.file_name' => 'nullable|string|max:255', // Added validation for file_name
            'attachments.*.thumbnail_url' => 'nullable|url|max:2048', // Validate thumbnail URL with max length
            'attachments.*.description' => 'nullable|string|max:500', // Validate description with max length
            'attachments.*.duration' => 'nullable|integer|min:0', // Ensure duration is a non-negative integer
            'deleted_attachments.*' => 'nullable|exists:attachments,id', // Validate IDs of attachments to be deleted
        ];
    }

    // Optional: Custom messages for validation errors
    // public function messages()
    // {
    //     return [
    //         'body.required' => 'The post body is required.',
    //         'body.max' => 'The post body may not be greater than 1000 characters.',
    //         'location.max' => 'The location may not be greater than 255 characters.',
    //         'privacy_id.required' => 'The privacy ID is required.',
    //         'privacy_id.exists' => 'The selected privacy ID is invalid.',
    //         'attachments.array' => 'Attachments must be an array.',
    //         'attachments.*.id.exists' => 'The specified attachment ID does not exist.',
    //         'attachments.*.type.in' => 'The attachment type must be one of the following: image, video, link, document.',
    //         'attachments.*.url.url' => 'The attachment URL must be a valid URL.',
    //         'attachments.*.url.max' => 'The attachment URL may not be greater than 2048 characters.',
    //         'attachments.*.path.string' => 'The attachment path must be a string.',
    //         'attachments.*.path.max' => 'The attachment path may not be greater than 255 characters.',
    //         'attachments.*.file_name.string' => 'The file name must be a string.',
    //         'attachments.*.file_name.max' => 'The file name may not be greater than 255 characters.',
    //         'attachments.*.thumbnail_url.url' => 'The thumbnail URL must be a valid URL.',
    //         'attachments.*.thumbnail_url.max' => 'The thumbnail URL may not be greater than 2048 characters.',
    //         'attachments.*.description.max' => 'The description may not be greater than 500 characters.',
    //         'attachments.*.duration.integer' => 'The duration must be an integer.',
    //         'attachments.*.duration.min' => 'The duration must be at least 0.',
    //         'deleted_attachments.*.exists' => 'The specified attachment ID for deletion does not exist.',
    //     ];
    // }
}
