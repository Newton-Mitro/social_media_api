<?php

namespace App\Modules\Post\Application\Resources;

use DateTimeImmutable;


class AttachmentResource
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
