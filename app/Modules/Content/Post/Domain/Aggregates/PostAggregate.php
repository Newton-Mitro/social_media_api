<?php

namespace App\Modules\Content\Post\Domain\Aggregates;

use App\Core\Entities\BaseEntity;
use App\Modules\Auth\Domain\Aggregates\UserAggregate;
use App\Modules\Content\Attachment\Domain\Entities\AttachmentEntity;
use App\Modules\Content\Post\Domain\ValueObjects\PostStatus;
use App\Modules\Content\Privacy\Domain\Entities\PrivacyEntity;
use App\Modules\Content\Reaction\Domain\Entities\ReactionEntity;
use DateTimeImmutable;
use Illuminate\Support\Collection;

class PostAggregate extends BaseEntity
{
    private ?string $postText;
    private PrivacyEntity $privacy;
    private UserAggregate $creator;
    private Collection $attachments;
    private ?ReactionEntity $myReaction;
    private int $commentCount;
    private int $reactionCount;
    private int $viewCount;
    private int $shareCount;
    private ?PostStatus $status;
    private DateTimeImmutable $createdAt;
    private DateTimeImmutable $updatedAt;

    public function __construct(
        UserAggregate $creator,
        PrivacyEntity $privacy,
        ?string $postText = null,
        ?ReactionEntity $myReaction = null,
        int $reactionCount = 0,
        int $viewCount = 0,
        int $shareCount = 0,
        int $commentCount = 0,
        ?PostStatus $status = null,
        DateTimeImmutable $createdAt = new DateTimeImmutable(),
        DateTimeImmutable $updatedAt = new DateTimeImmutable(),
        ?string $id = null,
    ) {
        parent::__construct($id);
        $this->postText = $postText;
        $this->privacy = $privacy;
        $this->creator = $creator;
        $this->myReaction = $myReaction;
        $this->attachments = collect();
        $this->commentCount = $commentCount;
        $this->reactionCount = $reactionCount;
        $this->viewCount = $viewCount;
        $this->shareCount = $shareCount;
        $this->status = $status;
        $this->createdAt = $createdAt;
        $this->updatedAt = $updatedAt;
    }

    // Getters for the properties
    public function getPostText(): ?string
    {
        return $this->postText;
    }

    public function getPrivacy(): PrivacyEntity
    {
        return $this->privacy;
    }

    public function getCreator(): UserAggregate
    {
        return $this->creator;
    }

    public function getAttachments(): Collection
    {
        return $this->attachments;
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

    public function getStatus(): ?PostStatus
    {
        return $this->status;
    }

    public function getMyReaction(): ?ReactionEntity
    {
        return $this->myReaction;
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
    public function setPostText(?string $postText): void
    {
        $this->postText = $postText;
    }

    public function setPrivacy(PrivacyEntity $privacy): void
    {
        $this->privacy = $privacy;
    }

    public function setMyReaction(?ReactionEntity $reaction): void
    {
        $this->myReaction = $reaction;
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

    public function setStatus(?PostStatus $status): void
    {
        $this->status = $status;
    }

    public function setCreatedAt(DateTimeImmutable $createdAt): void
    {
        $this->createdAt = $createdAt;
    }

    public function setUpdatedAt(DateTimeImmutable $updatedAt): void
    {
        $this->updatedAt = $updatedAt;
    }

    // Methods to manage attachments
    public function addAttachment(AttachmentEntity $attachment): void
    {
        $this->attachments->push($attachment);
    }

    public function removeAttachment(AttachmentEntity $attachment): void
    {
        if ($this->attachments->contains($attachment)) {
            $this->attachments->forget($this->attachments->search($attachment));
        }
    }

    public function updateAttachment(AttachmentEntity $oldAttachment, AttachmentEntity $newAttachment): void
    {
        $this->removeAttachment($oldAttachment);
        $this->addAttachment($newAttachment);
    }
}
