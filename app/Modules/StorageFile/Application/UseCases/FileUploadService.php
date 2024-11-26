<?php

namespace App\Modules\StorageFile\Application\UseCases;

use App\Modules\StorageFile\Application\DTOs\UploadedFileDTO;
use App\Modules\StorageFile\Domain\Interfaces\FileUploadServiceInterface;
use FFMpeg\Coordinate\TimeCode;
use FFMpeg\FFMpeg;
use Illuminate\Http\Response;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager;
use Intervention\Image\ImageManagerStatic as Image;
use Symfony\Component\CssSelector\Exception\InternalErrorException;

class FileUploadService implements FileUploadServiceInterface
{
    public function uploadFile(UploadedFile $file): UploadedFileDTO
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
            if ($this->isImage($file)) {
                $thumbnailPath = $this->createImageThumbnail($path, $fileName, $fileExtension);
                $uploadedFileResponse->thumbnail_url = asset(Storage::url($thumbnailPath));
            } elseif ($this->isVideo($file)) {
                $thumbnailPath = $this->createVideoThumbnail($path, $fileName);
                $uploadedFileResponse->thumbnail_url = asset(Storage::url($thumbnailPath));

                // Optionally, calculate video duration
                $uploadedFileResponse->duration = $this->getVideoDuration($path);
            }

            // Populate additional optional fields
            $uploadedFileResponse->title = null;  // Add logic to set this if needed
            $uploadedFileResponse->description = null;

            return $uploadedFileResponse;
        } catch (\Exception $e) {
            throw new InternalErrorException("File upload failed: " . $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    private function isImage(UploadedFile $file): bool
    {
        return str_starts_with($file->getMimeType(), 'image/');
    }

    private function isVideo(UploadedFile $file): bool
    {
        return str_starts_with($file->getMimeType(), 'video/');
    }

    private function createImageThumbnail(string $path, string $fileName, string $fileExtension): string
    {
        $thumbnailDir = 'uploads/thumbnails';
        $thumbnailPath = $thumbnailDir . '/' . pathinfo($fileName, PATHINFO_FILENAME) . '_thumb.' . $fileExtension;

        try {
            if (!Storage::disk('public')->exists($thumbnailDir)) {
                Storage::disk('public')->makeDirectory($thumbnailDir);
            }

            // $manager = new ImageManager(Driver::class);
            // $image = $manager->read(Storage::disk('public')->path($path));
            // $image->scaleDown(width: 200);

            $image = $image = ImageManager::imagick()->read(Storage::disk('public')->path($path));

            $image->resize(200, 200, function ($constraint) {
                $constraint->aspectRatio(); // Maintain aspect ratio
            });
            $image->save(Storage::disk('public')->path($thumbnailPath));
        } catch (\Exception $e) {
            throw new InternalErrorException("Image thumbnail creation failed: " . $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return $thumbnailPath;
    }

    private function createVideoThumbnail(string $path, string $fileName): string
    {
        $thumbnailPath = 'uploads/thumbnails/' . pathinfo($fileName, PATHINFO_FILENAME) . '_thumb.jpg';

        try {
            $ffmpeg = FFMpeg::create();
            $video = $ffmpeg->open(Storage::disk('public')->path($path));
            $video->frame(TimeCode::fromSeconds(5)) // Capture a frame at 5 second
                ->save(Storage::disk('public')->path($thumbnailPath));
        } catch (\Exception $e) {
            throw new InternalErrorException("Video thumbnail creation failed: " . $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return $thumbnailPath;
    }

    private function getVideoDuration(string $path): float
    {
        try {
            $ffmpeg = FFMpeg::create();
            $video = $ffmpeg->open(Storage::disk('public')->path($path));
            $duration = $video->getFormat()->get('duration'); // Get duration in seconds
            return $duration;
        } catch (\Exception $e) {
            throw new InternalErrorException("Failed to retrieve video duration: " . $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
