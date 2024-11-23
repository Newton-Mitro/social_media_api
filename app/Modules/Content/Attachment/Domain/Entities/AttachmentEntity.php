<?php

namespace App\Modules\Content\Attachment\Domain\Entities;

use App\Core\Entities\BaseEntity;
use DateTimeImmutable;

class AttachmentEntity extends BaseEntity
{
    private string $postId;
    private ?string $title;
    private ?string $description;
    private float $duration;
    private ?string $fileName;
    private ?string $filePath;
    private ?string $fileURL;
    private ?string $thumbnailUrl;
    private string $mimeType;
    private int $commentCount;
    private int $reactionCount;
    private int $viewCount;
    private int $shareCount;
    private DateTimeImmutable $createdAt;
    private DateTimeImmutable $updatedAt;

    public function __construct(
        string $postId,
        string $mimeType,
        ?string $fileName = null,
        ?string $filePath = null,
        ?string $fileURL = null,
        ?string $thumbnailUrl = null,
        ?string $title = null,
        ?string $description = null,
        float $duration = 0,
        int $reactionCount = 0,
        int $viewCount = 0,
        int $shareCount = 0,
        int $commentCount = 0,
        DateTimeImmutable $createdAt = new DateTimeImmutable(),
        DateTimeImmutable $updatedAt = new DateTimeImmutable(),
        ?string $id = null
    ) {
        parent::__construct($id);
        $this->postId = $postId;
        $this->title = $title;
        $this->description = $description;
        $this->duration = $duration;
        $this->fileName = $fileName;
        $this->filePath = $filePath;
        $this->fileURL = $fileURL;
        $this->thumbnailUrl = $thumbnailUrl;
        $this->mimeType = $mimeType;
        $this->commentCount = $commentCount;
        $this->reactionCount = $reactionCount;
        $this->viewCount = $viewCount;
        $this->shareCount = $shareCount;
        $this->createdAt = $createdAt;
        $this->updatedAt = $updatedAt;
    }

    // Getters for the properties
    public function getPostId(): string
    {
        return $this->postId;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function getDuration(): float
    {
        return $this->duration;
    }

    public function getFileName(): ?string
    {
        return $this->fileName;
    }

    public function getFilePath(): ?string
    {
        return $this->filePath;
    }

    public function getFileURL(): ?string
    {
        return $this->fileURL;
    }

    public function getThumbnailURL(): ?string
    {
        return $this->thumbnailUrl;
    }

    public function getMimeType(): string
    {
        return $this->mimeType;
    }

    public function getCommentCount(): int
    {
        return $this->commentCount;
    }

    public function getReactionCount(): int
    {
        return $this->reactionCount;
    }

    public function getViewCount(): int
    {
        return $this->viewCount;
    }

    public function getShareCount(): int
    {
        return $this->shareCount;
    }

    public function getCreatedAt(): DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function getUpdatedAt(): DateTimeImmutable
    {
        return $this->updatedAt;
    }

    // Setters for properties
    public function setPostId(string $postId): void
    {
        $this->postId = $postId;
    }

    public function setTitle(?string $title): void
    {
        $this->title = $title;
    }

    public function setDescription(?string $description): void
    {
        $this->description = $description;
    }

    public function setDuration(float $duration): void
    {
        $this->duration = $duration;
    }

    public function setFileName(?string $fileName): void
    {
        $this->fileName = $fileName;
    }

    public function setFilePath(?string $filePath): void
    {
        $this->filePath = $filePath;
    }

    public function setFileURL(?string $fileURL): void
    {
        $this->fileURL = $fileURL;
    }

    public function setThumbnailURL(?string $thumbnailUrl): void
    {
        $this->thumbnailUrl = $thumbnailUrl;
    }

    public function setMimeType(string $mimeType): void
    {
        $this->mimeType = $mimeType;
    }

    public function setCommentCount(int $commentCount): void
    {
        $this->commentCount = $commentCount;
    }

    public function setReactionCount(int $reactionCount): void
    {
        $this->reactionCount = $reactionCount;
    }

    public function setViewCount(int $viewCount): void
    {
        $this->viewCount = $viewCount;
    }

    public function setShareCount(int $shareCount): void
    {
        $this->shareCount = $shareCount;
    }

    public function setCreatedAt(DateTimeImmutable $createdAt): void
    {
        $this->createdAt = $createdAt;
    }

    public function setUpdatedAt(DateTimeImmutable $updatedAt): void
    {
        $this->updatedAt = $updatedAt;
    }
}
