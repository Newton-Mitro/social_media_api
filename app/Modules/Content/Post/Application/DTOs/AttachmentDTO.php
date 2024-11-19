<?php

namespace App\Modules\Content\Post\Application\DTOs;

use DateTimeImmutable;


class AttachmentDTO
{
    public function __construct(
        public string $id,
        public string $postId,
        public string $fileURL,
        public string $mimeType,
        public string $fileName,
        public string $filePath,
        public string $title,
        public string $description,
        public int $reactionCount,
        public int $viewCount,
        public int $shareCount,
        public int $commentCount,
        public DateTimeImmutable $createdAt,
        public DateTimeImmutable $updatedAt
    ) {}
}
