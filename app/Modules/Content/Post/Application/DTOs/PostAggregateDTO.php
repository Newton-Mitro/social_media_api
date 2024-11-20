<?php

namespace App\Modules\Content\Post\Application\DTOs;

use App\Modules\Auth\Application\DTOs\UserDTO;
use App\Modules\Content\Attachment\Application\DTOs\AttachmentDTO;
use App\Modules\Content\Post\Domain\ValueObjects\PostStatus;
use App\Modules\Content\Privacy\Application\DTOs\PrivacyDTO;
use App\Modules\Content\Reaction\Application\DTOs\ReactionDTO;
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
        public ReactionDTO $my_reaction,
        public int $reaction_count,
        public int $view_count,
        public int $share_count,
        public int $comment_count,
        public string $status,
        public DateTimeImmutable $created_at,
        public DateTimeImmutable $updated_at
    ) {
        $this->attachments = collect();
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
