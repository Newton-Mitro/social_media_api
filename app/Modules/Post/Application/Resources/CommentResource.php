<?php

namespace App\Modules\Post\Domain\Entities;

use DateTimeImmutable;

class CommentResource
{


    public function __construct(
        public string $id,
        public string $postId,
        public string $authorId,
        public string $content,
        public DateTimeImmutable $createdAt
    ) {}
}
