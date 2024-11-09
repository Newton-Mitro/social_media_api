<?php

namespace App\Modules\Post\Domain\Entities;

use App\Modules\Auth\User\Domain\Entities\UserEntity;
use App\Modules\Post\Domain\Entities\ReactionEntity;
use App\Modules\Post\Domain\Entities\AttachmentEntity;
use App\Modules\Post\Domain\Entities\ViewEntity;
use App\Modules\Post\Domain\Entities\ShareEntity;
use Illuminate\Support\Collection;

class PostAggregate
{
    private string $id;
    private string $content;
    private ?PrivacyEntity $privacy;
    private string $privacyId;
    private ?UserEntity $creator;
    private string $createdBy;
    private Collection $attachments;
    private Collection $comments;
    private int $commentCount;
    private Collection $reactions;
    private int $reactionCount;
    private ?ReactionEntity $myReaction;
    private Collection $views;
    private int $viewCount;
    private Collection $shares;
    private int $shareCount;
    private bool $active;
    private \DateTimeImmutable $createdAt;
    private \DateTimeImmutable $updatedAt;

    public function __construct(
        string $id,
        string $content,
        string $privacyId,
        string $createdBy,
        bool $active,
        \DateTimeImmutable $createdAt,
        \DateTimeImmutable $updatedAt,
        int $reactionCount = 0,
        int $viewCount = 0,
        int $shareCount = 0,
        int $commentCount = 0,
        ?UserEntity $creator = null,
        ?PrivacyEntity $privacy = null,
        ?ReactionEntity $myReaction = null
    ) {
        $this->id = $id;
        $this->content = $content;
        $this->privacy = $privacy;
        $this->privacyId = $privacyId;
        $this->creator = $creator;
        $this->createdBy = $createdBy;
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
        $this->active = $active;
        $this->createdAt = $createdAt;
        $this->updatedAt = $updatedAt;
    }

    // Getters for the properties
    public function getId(): string
    {
        return $this->id;
    }
    public function getContent(): string
    {
        return $this->content;
    }
    public function getPrivacy(): ?PrivacyEntity
    {
        return $this->privacy;
    }
    public function getPrivacyId(): string
    {
        return $this->privacyId;
    }
    public function getCreator(): ?UserEntity
    {
        return $this->creator;
    }
    public function getCreatedBy(): string
    {
        return $this->createdBy;
    }
    public function getAttachments(): Collection
    {
        return $this->attachments;
    }
    public function getComments(): Collection
    {
        return $this->comments;
    }
    public function getCommentCount(): int
    {
        return $this->commentCount;
    }
    public function getReactions(): Collection
    {
        return $this->reactions;
    }
    public function getReactionCount(): int
    {
        return $this->reactionCount;
    }
    public function getMyReaction(): ?ReactionEntity
    {
        return $this->myReaction;
    }
    public function getViews(): Collection
    {
        return $this->views;
    }
    public function getViewCount(): int
    {
        return $this->viewCount;
    }
    public function getShares(): Collection
    {
        return $this->shares;
    }
    public function getShareCount(): int
    {
        return $this->shareCount;
    }
    public function isActive(): bool
    {
        return $this->active;
    }
    public function getCreatedAt(): \DateTimeImmutable
    {
        return $this->createdAt;
    }
    public function getUpdatedAt(): \DateTimeImmutable
    {
        return $this->updatedAt;
    }

    // Methods to manage collections with type-hinting for each collection of entities
    public function addAttachment(AttachmentEntity $attachment): void
    {
        $this->attachments->push($attachment); // Add AttachmentEntity to collection
    }

    public function removeAttachment(AttachmentEntity $attachment): void
    {
        if ($this->attachments->contains($attachment)) {
            $this->attachments->forget($this->attachments->search($attachment)); // Remove AttachmentEntity
        }
    }

    public function updateAttachment(AttachmentEntity $oldAttachment, AttachmentEntity $newAttachment): void
    {
        $this->removeAttachment($oldAttachment);
        $this->addAttachment($newAttachment);
    }

    public function addComment(CommentEntity $comment): void
    {
        $this->comments->push($comment); // Add CommentEntity to collection
    }

    public function removeComment(CommentEntity $comment): void
    {
        if ($this->comments->contains($comment)) {
            $this->comments->forget($this->comments->search($comment)); // Remove CommentEntity
        }
    }

    public function updateComment(CommentEntity $oldComment, CommentEntity $newComment): void
    {
        $this->removeComment($oldComment);
        $this->addComment($newComment);
    }

    public function addReaction(ReactionEntity $reaction): void
    {
        $this->reactions->push($reaction); // Add ReactionEntity to collection
    }

    public function removeReaction(ReactionEntity $reaction): void
    {
        if ($this->reactions->contains($reaction)) {
            $this->reactions->forget($this->reactions->search($reaction)); // Remove ReactionEntity
        }
    }

    public function updateReaction(ReactionEntity $oldReaction, ReactionEntity $newReaction): void
    {
        $this->removeReaction($oldReaction);
        $this->addReaction($newReaction);
    }

    public function addView(ViewEntity $view): void
    {
        $this->views->push($view); // Add ViewEntity to collection
    }

    public function removeView(ViewEntity $view): void
    {
        if ($this->views->contains($view)) {
            $this->views->forget($this->views->search($view)); // Remove ViewEntity
        }
    }

    public function updateView(ViewEntity $oldView, ViewEntity $newView): void
    {
        $this->removeView($oldView);
        $this->addView($newView);
    }

    public function addShare(ShareEntity $share): void
    {
        $this->shares->push($share); // Add ShareEntity to collection
    }

    public function removeShare(ShareEntity $share): void
    {
        if ($this->shares->contains($share)) {
            $this->shares->forget($this->shares->search($share)); // Remove ShareEntity
        }
    }

    public function updateShare(ShareEntity $oldShare, ShareEntity $newShare): void
    {
        $this->removeShare($oldShare);
        $this->addShare($newShare);
    }

    // Specific methods for `myReaction` and `active`
    public function setMyReaction(?ReactionEntity $reaction): void
    {
        $this->myReaction = $reaction;
    }
    public function deactivate(): void
    {
        $this->active = false;
    }
    public function activate(): void
    {
        $this->active = true;
    }
}
