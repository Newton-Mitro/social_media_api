<?php

namespace App\Modules\Follow\Application\DTOs;

use DateTimeImmutable;


class FollowDTO
{
    public function __construct(
        public string $id,
        public string $postId,
        public string $fileURL,
        public DateTimeImmutable $createdAt,
        public DateTimeImmutable $updatedAt
    ) {}
}
