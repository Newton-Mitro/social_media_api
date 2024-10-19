<?php

namespace App\Modules\Post\BusinessModels;

use App\Modules\Auth\User\BusinessModels\UserModel;
use DateTimeImmutable;

class AttachmentModel
{
    public function __construct(
        private int            $attachmentId,
        private int            $postId,
        private string            $fileName,
        private string            $filePath,
        private string            $fileURL,
        private string            $mimeType,
        private int $createdBy,
        private ?UserModel $creator = null,
        private int               $likeCount = 0,
        private int               $viewCount = 0,
        private int               $shareCount = 0,
        private DateTimeImmutable $createdAt = new DateTimeImmutable,
        private DateTimeImmutable $updatedAt = new DateTimeImmutable
    ) {}

    public function getAttachmentId(): int
    {
        return $this->attachmentId;
    }

    public function setAttachmentId(int $attachmentId): AttachmentModel
    {
        $this->attachmentId = $attachmentId;
        return $this;
    }

    public function getPostId(): int
    {
        return $this->postId;
    }

    public function setPostId(int $postId): AttachmentModel
    {
        $this->postId = $postId;
        return $this;
    }

    public function getFileName(): string
    {
        return $this->fileName;
    }

    public function setFileName(string $fileName): AttachmentModel
    {
        $this->fileName = $fileName;
        return $this;
    }

    public function getFilePath(): string
    {
        return $this->filePath;
    }

    public function setFilePath(string $filePath): AttachmentModel
    {
        $this->filePath = $filePath;
        return $this;
    }

    public function getFileURL(): string
    {
        return $this->fileURL;
    }

    public function setFileURL(string $fileURL): AttachmentModel
    {
        $this->fileURL = $fileURL;
        return $this;
    }

    public function getMimeType(): string
    {
        return $this->mimeType;
    }

    public function setMimeType(string $mimeType): AttachmentModel
    {
        $this->mimeType = $mimeType;
        return $this;
    }

    public function getCreatedBy(): int
    {
        return $this->createdBy;
    }

    public function setCreatedBy(int $createdBy): AttachmentModel
    {
        $this->createdBy = $createdBy;
        return $this;
    }

    public function getCreator(): ?UserModel
    {
        return $this->creator;
    }

    public function setCreator(?UserModel $creator): AttachmentModel
    {
        $this->creator = $creator;
        return $this;
    }

    public function getLikeCount(): int
    {
        return $this->likeCount;
    }

    public function setLikeCount(int $likeCount): AttachmentModel
    {
        $this->likeCount = $likeCount;
        return $this;
    }

    public function getViewCount(): int
    {
        return $this->viewCount;
    }

    public function setViewCount(int $viewCount): AttachmentModel
    {
        $this->viewCount = $viewCount;
        return $this;
    }

    public function getShareCount(): int
    {
        return $this->shareCount;
    }

    public function setShareCount(int $shareCount): AttachmentModel
    {
        $this->shareCount = $shareCount;
        return $this;
    }

    public function getCreatedAt(): DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(DateTimeImmutable $createdAt): AttachmentModel
    {
        $this->createdAt = $createdAt;
        return $this;
    }

    public function getUpdatedAt(): DateTimeImmutable
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(DateTimeImmutable $updatedAt): AttachmentModel
    {
        $this->updatedAt = $updatedAt;
        return $this;
    }
}
