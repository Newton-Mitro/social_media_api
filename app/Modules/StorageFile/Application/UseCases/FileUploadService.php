<?php

namespace App\Modules\StorageFile\Application\UseCases;

use App\Modules\StorageFile\Core\Interfaces\FileUploadServiceInterface;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class FileUploadService implements FileUploadServiceInterface
{
    public function uploadFile(UploadedFile $file): array
    {
        // Store the file in the "uploads" directory under the "public" disk
        $path = $file->store('uploads', 'public');

        return [
            'file_name' => basename($path),
            'file_type' => $file->getMimeType(),
            'url' => asset(Storage::url($path)),
            'path' => $path,
        ];
    }
}
