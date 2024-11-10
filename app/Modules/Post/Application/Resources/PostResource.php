<?php

namespace App\Modules\Post\Application\Resources;

use App\Modules\Auth\Authentication\Application\Resources\UserResource;



class PostResource
{
    public int               $postId;
    public int            $userId;
    public string            $body;
    public int            $privacyId;
    public int $createdBy;
    public ?UserResource $creator;
    public array            $attachments;
    public int               $likeCount;
    public int               $shareCount;
    public string $createdAt;
    public string $updatedAt;
    public ?string $expireDate;
}
