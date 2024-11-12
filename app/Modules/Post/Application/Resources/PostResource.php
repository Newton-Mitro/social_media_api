<?php

namespace App\Modules\Post\Application\Resources;

class PostResource
{
    public string               $postId;
    public string            $userId;
    public string            $body;
    public string            $privacyId;
    public string $createdBy;
    public int               $likeCount;
    public int               $shareCount;
    public string $createdAt;
    public string $updatedAt;
}
