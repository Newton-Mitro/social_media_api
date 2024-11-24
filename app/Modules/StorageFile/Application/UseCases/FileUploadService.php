<?php

namespace App\Modules\StorageFile\Application\UseCases;

use App\Modules\StorageFile\Application\DTOs\UploadedFileDTO;
use App\Modules\StorageFile\Domain\Interfaces\FileUploadServiceInterface;
use FFMpeg\Coordinate\TimeCode;
use FFMpeg\FFMpeg;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Image;

class FileUploadService implements FileUploadServiceInterface
{
    /**
     * Upload a file and process it based on its type (image/video).
     *
     * @param UploadedFile $file
     * @return UploadedFileDTO
     * @throws \Exception
     */
    public function uploadFile(UploadedFile $file): UploadedFileDTO
    {
        try {
            // Store the original file in the "uploads" directory under the "public" disk
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
            throw new \Exception("File upload failed: " . $e->getMessage());
        }
    }

    /**
     * Check if the uploaded file is an image.
     *
     * @param UploadedFile $file
     * @return bool
     */
    private function isImage(UploadedFile $file): bool
    {
        return str_starts_with($file->getMimeType(), 'image/');
    }

    /**
     * Check if the uploaded file is a video.
     *
     * @param UploadedFile $file
     * @return bool
     */
    private function isVideo(UploadedFile $file): bool
    {
        return str_starts_with($file->getMimeType(), 'video/');
    }

    /**
     * Create a thumbnail for the uploaded image.
     *
     * @param string $path
     * @param string $fileName
     * @param string $fileExtension
     * @return string
     * @throws \Exception
     */
    private function createImageThumbnail(string $path, string $fileName, string $fileExtension): string
    {
        $thumbnailPath = 'uploads/thumbnails/' . pathinfo($fileName, PATHINFO_FILENAME) . '_thumb.' . $fileExtension;

        try {
            $image = Image::make(Storage::disk('public')->path($path));
            $image->resize(200, 200, function ($constraint) {
                $constraint->aspectRatio(); // Maintain aspect ratio
            });
            $image->save(Storage::disk('public')->path($thumbnailPath));
        } catch (\Exception $e) {
            throw new \Exception("Image thumbnail creation failed: " . $e->getMessage());
        }

        return $thumbnailPath;
    }

    /**
     * Create a thumbnail for the uploaded video.
     *
     * @param string $path
     * @param string $fileName
     * @return string
     * @throws \Exception
     */
    private function createVideoThumbnail(string $path, string $fileName): string
    {
        $thumbnailPath = 'uploads/thumbnails/' . pathinfo($fileName, PATHINFO_FILENAME) . '_thumb.jpg';

        try {
            $ffmpeg = FFMpeg::create();
            $video = $ffmpeg->open(Storage::disk('public')->path($path));
            $video->frame(TimeCode::fromSeconds(1)) // Capture a frame at 1 second
                ->save(Storage::disk('public')->path($thumbnailPath));
        } catch (\Exception $e) {
            throw new \Exception("Video thumbnail creation failed: " . $e->getMessage());
        }

        return $thumbnailPath;
    }

    /**
     * Get the duration of a video file in seconds.
     *
     * @param string $path
     * @return float
     * @throws \Exception
     */
    private function getVideoDuration(string $path): float
    {
        try {
            $ffmpeg = FFMpeg::create();
            $video = $ffmpeg->open(Storage::disk('public')->path($path));
            $duration = $video->getFormat()->get('duration'); // Get duration in seconds
            return $duration;
        } catch (\Exception $e) {
            throw new \Exception("Failed to retrieve video duration: " . $e->getMessage());
        }
    }
}
