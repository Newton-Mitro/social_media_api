<?php

namespace App\Features\Post\UseCases\Commands\CreatePost;

use App\Core\Bus\Command;
use DateTimeImmutable;

class CreatePostCommand extends Command
{
    public function __construct(
        private readonly int               $userId,
        private readonly string            $body,
        private readonly int               $privacyId,
        private readonly array             $attachments = [],
        private readonly DateTimeImmutable $createdAt = new DateTimeImmutable(),
        private readonly DateTimeImmutable $updatedAt = new DateTimeImmutable()
    ) {}

    public function getUserId(): int
    {
        return $this->userId;
    }

    public function getBody(): string
    {
        return $this->body;
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
