<?php

namespace App\Modules\StorageFile\Application\UseCases;

use App\Modules\StorageFile\Application\DTOs\UploadedFileDTO;
use App\Modules\StorageFile\Domain\Interfaces\FileUploadServiceInterface;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Image;

class FileUploadService implements FileUploadServiceInterface
{
    public function uploadFile(UploadedFile $file): UploadedFileDTO
    {
        // Store the original file in the "uploads" directory under the "public" disk
        $path = $file->store('uploads', 'public');

        // Create a new UploadedFileDTO instance
        $uploadedFileResponse = new UploadedFileDTO();

        // Get the file name and extension
        $fileName = basename($path);
        $fileExtension = $file->getClientOriginalExtension();

        // Create a thumbnail image
        $thumbnailPath = 'uploads/thumbnails/' . pathinfo($fileName, PATHINFO_FILENAME) . '_thumb.' . $fileExtension;

        // Resize the image and create the thumbnail
        $image = Image::make(Storage::path($path)); // Open the uploaded file
        $image->resize(200, 200, function ($constraint) {
            $constraint->aspectRatio(); // Maintain aspect ratio
        });

        // Save the thumbnail to the public disk
        $image->save(Storage::path($thumbnailPath));

        // Populate the DTO object with file and thumbnail information
        $uploadedFileResponse->file_url = asset(Storage::url($path));
        $uploadedFileResponse->file_path = $path;
        $uploadedFileResponse->file_name = $fileName;
        $uploadedFileResponse->mime_type = $file->getMimeType();
        $uploadedFileResponse->thumbnail_url = asset(Storage::url($thumbnailPath)); // Thumbnail URL
        $uploadedFileResponse->title = null;  // Set null or pass an actual value based on your logic
        $uploadedFileResponse->description = null;  // Same as above
        $uploadedFileResponse->duration = 0.0;  // If it's an audio/video file, you'd update this with actual duration

        // Return the complete DTO
        return $uploadedFileResponse;
    }
}
