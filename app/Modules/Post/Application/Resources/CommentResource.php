<?php

namespace App\Modules\Post\Domain\Entities;

use App\Modules\Auth\Application\Resources\UserResource;
use DateTimeImmutable;

class CommentResource
{
    public function __construct(
        public string $id,
        public string $postId,
        public UserResource $author,
        public string $content,
        public DateTimeImmutable $createdAt,
        public DateTimeImmutable $updatedAt,
    ) {}
}
