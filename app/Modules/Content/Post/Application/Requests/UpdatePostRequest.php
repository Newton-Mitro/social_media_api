<?php

namespace App\Modules\Content\Post\Application\Requests;

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
            'post_text' => 'sometimes|required|string',
            'location' => 'sometimes|nullable|string',
            'privacy_id' => 'sometimes|required|exists:privacies,id',
            'attachments.*.id' => 'nullable|exists:attachments,id',
            'attachments.*' => [
                'file',
                'mimes:jpeg,png,gif,mp4,mp3,doc,pdf',
                function ($attribute, $value, $fail) {
                    $maxSizes = [
                        'image' => 1024,    // 1 MB for images
                        'video' => 10240,   // 10 MB for videos
                        'document' => 1024, // 1 MB for documents
                        'audio' => 3072     // 3 MB for audio
                    ];

                    $mimeType = $value->getMimeType();
                    $fileSize = $value->getSize() / 1024; // KB

                    if (str_contains($mimeType, 'image') && $fileSize > $maxSizes['image']) {
                        return $fail("The {$attribute} image must not be greater than {$maxSizes['image']} KB.");
                    }

                    if (str_contains($mimeType, 'video') && $fileSize > $maxSizes['video']) {
                        return $fail("The {$attribute} video must not be greater than {$maxSizes['video']} KB.");
                    }

                    if ((str_contains($mimeType, 'pdf') || str_contains($mimeType, 'msword')) && $fileSize > $maxSizes['document']) {
                        return $fail("The {$attribute} document must not be greater than {$maxSizes['document']} KB.");
                    }

                    if (str_contains($mimeType, 'audio') && $fileSize > $maxSizes['audio']) {
                        return $fail("The {$attribute} audio must not be greater than {$maxSizes['audio']} KB.");
                    }
                },
            ],
        ];
    }
}
