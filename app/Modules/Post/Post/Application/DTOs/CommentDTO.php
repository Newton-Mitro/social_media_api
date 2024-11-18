<?php

namespace App\Modules\Post\Domain\Entities;

use App\Modules\Auth\Application\DTOs\UserDTO;
use DateTimeImmutable;

class CommentDTO
{
    public function __construct(
        public string $id,
        public string $postId,
        public UserDTO $author,
        public string $content,
        public DateTimeImmutable $createdAt,
        public DateTimeImmutable $updatedAt,
    ) {}
}
