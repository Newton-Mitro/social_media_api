<?php

namespace App\Modules\Friend\Application\DTOs;

use DateTimeImmutable;


class FriendRequestDTO
{
    public function __construct(
        public string $id,
        public string $postId,
        public string $fileURL,
        public DateTimeImmutable $createdAt,
        public DateTimeImmutable $updatedAt
    ) {}
}
