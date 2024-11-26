<?php

namespace App\Core\Utilities;


use FFMpeg\Coordinate\TimeCode;
use FFMpeg\FFMpeg;
use Illuminate\Http\Response;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManager;
use Symfony\Component\CssSelector\Exception\InternalErrorException;

class FileUtil
{
    public static function isImage(UploadedFile $file): bool
    {
        return str_starts_with($file->getMimeType(), 'image/');
    }

    public static function isVideo(UploadedFile $file): bool
    {
        return str_starts_with($file->getMimeType(), 'video/');
    }

    public static function createImageThumbnail(string $path, string $fileName, string $fileExtension): string
    {
        $thumbnailDir = 'uploads/thumbnails';
        $thumbnailPath = $thumbnailDir . '/' . pathinfo($fileName, PATHINFO_FILENAME) . '_thumb.' . $fileExtension;

        try {
            if (!Storage::disk('public')->exists($thumbnailDir)) {
                Storage::disk('public')->makeDirectory($thumbnailDir);
            }

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

    public static function createVideoThumbnail(string $path, string $fileName): string
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

    public static function getVideoDuration(string $path): float
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
