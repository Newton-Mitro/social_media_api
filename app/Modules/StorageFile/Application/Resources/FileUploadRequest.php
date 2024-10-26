<?php

namespace App\Modules\StorageFile\Application\Resources;

use Illuminate\Foundation\Http\FormRequest;

class FileUploadRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // Adjust authorization as needed
    }

    public function rules(): array
    {
        return [
            'file' => 'required|file|mimes:jpg,jpeg,png,gif,mp4,pdf,doc,docx|max:2048',
        ];
    }
}
