<?php

namespace App\Modules\Post\Core\Entities;

use App\Modules\Auth\User\BusinessModels\UserModel;
use DateTimeImmutable;

class PostModel
{
    public function __construct(
        private string               $postId,
        private string            $userId,
        private string            $body,
        private string            $existing_content_url,
        private int            $privacyId,
        private int $createdBy,
        private ?UserModel $creator = null,
        public array            $attachments = [],
        private int               $likeCount = 0,
        private int               $viewCount = 0,
        private int               $shareCount = 0,
        private bool              $active = true,
        private DateTimeImmutable $createdAt = new DateTimeImmutable,
        private DateTimeImmutable $updatedAt = new DateTimeImmutable,
        private ?DateTimeImmutable $expireDate = null
    ) {}

    public function getUserId(): string
    {
        return $this->userId;
    }

    public function setUserId(string $userId): PostModel
    {
        $this->userId = $userId;
        return $this;
    }

    public function getBody(): string
    {
        return $this->body;
    }

    public function setBody(string $body): PostModel
    {
        $this->body = $body;
        return $this;
    }

    public function getExistingContentUrl(): string
    {
        return $this->existing_content_url;
    }

    public function setExistingContentUrl(string $existing_content_url): PostModel
    {
        $this->existing_content_url = $existing_content_url;
        return $this;
    }

    public function getPrivacyId(): int
    {
        return $this->privacyId;
    }

    public function setPrivacyId(int $privacyId): PostModel
    {
        $this->privacyId = $privacyId;
        return $this;
    }

    public function getCreatedBy(): int
    {
        return $this->createdBy;
    }

    public function setCreatedBy(int $createdBy): PostModel
    {
        $this->createdBy = $createdBy;
        return $this;
    }

    public function getCreator(): ?UserModel
    {
        return $this->creator;
    }

    public function setCreator(?UserModel $creator): PostModel
    {
        $this->creator = $creator;
        return $this;
    }

    public function getAttachments(): array
    {
        return $this->attachments;
    }

    public function setAttachments(array $attachments): PostModel
    {
        $this->attachments = $attachments;
        return $this;
    }

    public function getPostId(): string
    {
        return $this->postId;
    }

    public function setPostId(string $postId): PostModel
    {
        $this->postId = $postId;
        return $this;
    }

    public function getLikeCount(): int
    {
        return $this->likeCount;
    }

    public function setLikeCount(int $likeCount): PostModel
    {
        $this->likeCount = $likeCount;
        return $this;
    }

    public function getViewCount(): int
    {
        return $this->viewCount;
    }

    public function setViewCount(int $viewCount): PostModel
    {
        $this->viewCount = $viewCount;
        return $this;
    }

    public function getShareCount(): int
    {
        return $this->shareCount;
    }

    public function setShareCount(int $shareCount): PostModel
    {
        $this->shareCount = $shareCount;
        return $this;
    }

    public function isActive(): bool
    {
        return $this->active;
    }

    public function setActive(bool $active): PostModel
    {
        $this->active = $active;
        return $this;
    }

    public function getCreatedAt(): DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(DateTimeImmutable $createdAt): PostModel
    {
        $this->createdAt = $createdAt;
        return $this;
    }

    public function getUpdatedAt(): DateTimeImmutable
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(DateTimeImmutable $updatedAt): PostModel
    {
        $this->updatedAt = $updatedAt;
        return $this;
    }

    public function getExpireDate(): ?DateTimeImmutable
    {
        return $this->expireDate;
    }

    public function setExpireDate(?DateTimeImmutable $expireDate): PostModel
    {
        $this->expireDate = $expireDate;
        return $this;
    }
}
