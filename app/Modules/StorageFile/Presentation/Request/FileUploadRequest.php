<?php

namespace App\Modules\StorageFile\Presentation\Request;

use Illuminate\Foundation\Http\FormRequest;

class FileUploadRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'attachment' => [
                'required',
                'file',
                'mimes:jpeg,png,gif,mp4,mp3,doc,pdf',
                function ($attribute, $value, $fail) {
                    // Define maximum size for each file type (in KB)
                    $maxSizes = [
                        'image' => 1024,    // 1 MB for images
                        'video' => 10240,   // 10 MB for videos
                        'document' => 1024, // 1 MB for documents
                        'audio' => 3072     // 3 MB for audio
                    ];

                    // Determine the file type
                    $mimeType = $value->getMimeType();
                    $fileSize = $value->getSize() / 1024; // Convert file size to KB

                    // Check if it's an image
                    if (str_contains($mimeType, 'image') && $fileSize > $maxSizes['image']) {
                        return $fail("The {$attribute} image must not be greater than {$maxSizes['image']} KB.");
                    }

                    // Check if it's a video
                    if (str_contains($mimeType, 'video') && $fileSize > $maxSizes['video']) {
                        return $fail("The {$attribute} video must not be greater than {$maxSizes['video']} KB.");
                    }

                    // Check if it's a document (PDF, doc)
                    if ((str_contains($mimeType, 'pdf') || str_contains($mimeType, 'msword')) && $fileSize > $maxSizes['document']) {
                        return $fail("The {$attribute} document must not be greater than {$maxSizes['document']} KB.");
                    }

                    // Check if it's an audio file (mp3)
                    if (str_contains($mimeType, 'audio') && $fileSize > $maxSizes['audio']) {
                        return $fail("The {$attribute} audio must not be greater than {$maxSizes['audio']} KB.");
                    }
                },
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'file.required' => 'A file is required for upload.',
            'file.file' => 'The uploaded item must be a file.',
            'file.mimes' => 'The file must be a type of: jpeg, png, gif, mp4, mp3, doc, pdf.',
        ];
    }
}
