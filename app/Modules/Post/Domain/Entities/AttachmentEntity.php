<?php

namespace App\Modules\Post\Domain\Entities;

use App\Core\Entities\BaseEntity;
use DateTimeImmutable;

class AttachmentEntity extends BaseEntity
{
    private string $postId;
    private string $title;
    private string $description;
    private string $fileName;
    private string $filePath;
    private string $fileURL;
    private string $mimeType;
    private int $commentCount;
    private int $reactionCount;
    private int $viewCount;
    private int $shareCount;
    private DateTimeImmutable $createdAt;
    private DateTimeImmutable $updatedAt;

    public function __construct(

        string $postId,
        string $fileURL,
        string $mimeType,
        string $fileName,
        string $filePath,
        ?string $title = null,
        ?string $description = null,
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
        $this->fileName = $fileName;
        $this->filePath = $filePath;
        $this->fileURL = $fileURL;
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

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function getFileName(): string
    {
        return $this->fileName;
    }

    public function getFilePath(): string
    {
        return $this->filePath;
    }

    public function getFileURL(): string
    {
        return $this->fileURL;
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
}
