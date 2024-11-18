<?php

namespace App\Modules\Post\Application\DTOs;

use App\Modules\Post\Domain\Entities\ReactionDTO;
use DateTimeImmutable;

class AttachmentAggregateDTO
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
        public ReactionDTO $myReaction,
        public DateTimeImmutable $createdAt,
        public DateTimeImmutable $updatedAt
    ) {
        $this->id = $id;
        $this->postId = $postId;
        $this->title = $title;
        $this->description = $description;
        $this->fileName = $fileName;
        $this->filePath = $filePath;
        $this->fileURL = $fileURL;
        $this->mimeType = $mimeType;
        $this->commentCount = $commentCount;
        $this->reactionCount = $reactionCount;
        $this->myReaction = $myReaction;
        $this->viewCount = $viewCount;
        $this->shareCount = $shareCount;
        $this->createdAt = $createdAt;
        $this->updatedAt = $updatedAt;
    }
}
