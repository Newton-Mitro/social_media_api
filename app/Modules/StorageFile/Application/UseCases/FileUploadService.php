<?php

namespace App\Modules\StorageFile\Application\UseCases;

use App\Core\Utilities\FileUtil;
use App\Modules\StorageFile\Application\DTOs\UploadedFileDTO;
use App\Modules\StorageFile\Domain\Interfaces\FileUploadServiceInterface;
use Illuminate\Http\Response;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\CssSelector\Exception\InternalErrorException;

class FileUploadService implements FileUploadServiceInterface
{
    public function uploadFile($file): UploadedFileDTO
    {
        try {
            $path = $file->store('uploads', 'public');

            // Extract file details
            $fileName = basename($path);
            $fileExtension = $file->getClientOriginalExtension();

            // Initialize UploadedFileDTO
            $uploadedFileResponse = new UploadedFileDTO();
            $uploadedFileResponse->file_url = asset(Storage::url($path));
            $uploadedFileResponse->file_path = $path;
            $uploadedFileResponse->file_name = $fileName;
            $uploadedFileResponse->mime_type = $file->getMimeType();

            // Process based on file type
            if (FileUtil::isImage($file)) {
                $thumbnailPath = FileUtil::createImageThumbnail($path, $fileName, $fileExtension);
                $uploadedFileResponse->thumbnail_url = asset(Storage::url($thumbnailPath));
            } elseif (FileUtil::isVideo($file)) {
                $thumbnailPath = FileUtil::createVideoThumbnail($path, $fileName);
                $uploadedFileResponse->thumbnail_url = asset(Storage::url($thumbnailPath));

                // Optionally, calculate video duration
                $uploadedFileResponse->duration = FileUtil::getVideoDuration($path);
            }

            // Populate additional optional fields
            $uploadedFileResponse->title = null;  // Add logic to set this if needed
            $uploadedFileResponse->description = null;

            return $uploadedFileResponse;
        } catch (\Exception $e) {
            throw new InternalErrorException("File upload failed: " . $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
