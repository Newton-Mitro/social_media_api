<?php

namespace App\Modules\Content\Post\Application\DTOs;

use App\Modules\Auth\Application\DTOs\UserAggregateDTO;
use App\Modules\Content\Attachment\Application\DTOs\AttachmentDTO;
use App\Modules\Content\Privacy\Application\DTOs\PrivacyDTO;
use App\Modules\Content\Reaction\Application\DTOs\ReactionDTO;
use Illuminate\Support\Collection;

class PostAggregateDTO
{


    public function __construct(
        public string $id,
        public ?string $postText,
        public UserAggregateDTO $creator,
        public PrivacyDTO $privacy,
        public ?ReactionDTO $my_reaction,
        public int $reaction_count,
        public int $view_count,
        public int $share_count,
        public int $comment_count,
        public ?string $status,
        public string $created_at,
        public string $updated_at
    ) {
        $this->attachments = collect();
    }

    public Collection $attachments;

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
