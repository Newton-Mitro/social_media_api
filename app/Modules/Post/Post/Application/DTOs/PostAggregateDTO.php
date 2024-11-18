<?php

namespace App\Modules\Post\Application\DTOs;

use App\Modules\Auth\Application\DTOs\UserDTO;
use App\Modules\Post\Domain\Entities\PrivacyDTO;
use App\Modules\Post\Domain\Entities\ReactionDTO;
use App\Modules\Post\Domain\Enums\PostStatus;
use DateTimeImmutable;
use Illuminate\Support\Collection;

class PostAggregateDTO
{
    public Collection $attachments;

    public function __construct(
        public string $id,
        public string $content,
        public UserDTO $creator,
        public PrivacyDTO $privacy,
        public ReactionDTO $myReaction,
        public int $reactionCount,
        public int $viewCount,
        public int $shareCount,
        public int $commentCount,
        public PostStatus $status,
        public DateTimeImmutable $createdAt,
        public DateTimeImmutable $updatedAt
    ) {
        $this->attachments = collect();
    }

    // Getter for Attachments
    public function getAttachments(): Collection
    {
        return $this->attachments;
    }

    // Add an Attachment
    public function addAttachment(AttachmentDTO $attachment): void
    {
        $this->attachments->push($attachment);
    }

    // Remove an Attachment
    public function removeAttachment(AttachmentDTO $attachment): void
    {
        if ($this->attachments->contains($attachment)) {
            $this->attachments->forget($this->attachments->search($attachment));
        }
    }
}
