<?php

namespace App\Modules\Post\Domain\Entities;

use App\Modules\Auth\Application\DTOs\UserDTO;
use App\Modules\Post\Domain\Enums\PostStatus;
use DateTimeImmutable;
use Illuminate\Support\Collection;

class PostAggregateDTO
{
    public Collection $attachments;
    public Collection $comments;
    public Collection $reactions;
    public Collection $views;
    public Collection $shares;

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
        $this->id = $id;
        $this->content = $content;
        $this->privacy = $privacy;
        $this->creator = $creator;
        $this->attachments = collect();
        $this->comments = collect();
        $this->commentCount = $commentCount;
        $this->reactions = collect();
        $this->reactionCount = $reactionCount;
        $this->myReaction = $myReaction;
        $this->views = collect();
        $this->viewCount = $viewCount;
        $this->shares = collect();
        $this->shareCount = $shareCount;
        $this->status = $status;
        $this->createdAt = $createdAt;
        $this->updatedAt = $updatedAt;
    }
}
