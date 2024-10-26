<?php

namespace App\Modules\Post\Http\Resources;

use App\Modules\Auth\User\Resources\UserResource;

class AttachmentResource
{
    public int            $attachmentId;
    public int            $postId;
    public string            $fileName;
    public string            $filePath;
    public string            $fileURL;
    public string            $mimeType;
    public int $createdBy;
    public ?UserResource $creator;
    public int               $likeCount;
    public int               $viewCount;
    public int               $shareCount;
    public string $createdAt;
    public string $updatedAt;
}
