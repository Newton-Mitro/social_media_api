<?php

namespace App\Features\Post\UseCases\Commands\UpdatePost;

use App\Core\Bus\Command;
use DateTimeImmutable;

class UpdatePostCommand extends Command
{
    public function __construct(
        private readonly int               $postId,
        private readonly int               $userId,
        private readonly string            $body,
        private readonly string            $existing_content_url,
        private readonly int               $privacyId,
        private readonly array             $attachments = [],
        private readonly DateTimeImmutable $createdAt = new DateTimeImmutable(),
        private readonly DateTimeImmutable $updatedAt = new DateTimeImmutable()
    ) {}

    public function getPostId(): int
    {
        return $this->postId;
    }
    
    public function getUserId(): int
    {
        return $this->userId;
    }

    public function getBody(): string
    {
        return $this->body;
    }
    
    public function getExistingContentUrl(): string
    {
        return $this->existing_content_url;
    }

    public function getPrivacyId(): int
    {
        return $this->privacyId;
    }

    public function getAttachments(): array
    {
        return $this->attachments;
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
