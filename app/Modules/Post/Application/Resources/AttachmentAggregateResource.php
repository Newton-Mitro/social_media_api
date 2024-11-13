<?php

namespace App\Modules\Post\Application\Resources;

use App\Modules\Post\Domain\Entities\ReactionResource;
use DateTimeImmutable;
use Illuminate\Support\Collection;

class AttachmentAggregateResource
{
    public Collection $comments;
    public Collection $reactions;
    public Collection $views;
    public Collection $shares;

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
        public ReactionResource $myReaction,
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
        $this->comments = collect();
        $this->commentCount = $commentCount;
        $this->reactions = collect();
        $this->reactionCount = $reactionCount;
        $this->myReaction = $myReaction;
        $this->views = collect();
        $this->viewCount = $viewCount;
        $this->shares = collect();
        $this->shareCount = $shareCount;
        $this->createdAt = $createdAt;
        $this->updatedAt = $updatedAt;
    }
}
