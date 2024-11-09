<?php

namespace App\Modules\Post\Domain\Entities;

use App\Modules\Post\Domain\Entities\CommentEntity;
use App\Modules\Post\Domain\Entities\ReactionEntity;
use App\Modules\Post\Domain\Entities\ShareEntity;
use App\Modules\Post\Domain\Entities\ViewEntity;
use Illuminate\Support\Collection;


class AttachmentEntity
{
    private string $attachmentId;
    private string $postId;
    private string $title;
    private string $description;
    private string $fileName;
    private string $filePath;
    private string $fileURL;
    private string $mimeType;
    private Collection $comments;  // Collection of CommentEntity
    private int $commentCount;
    private Collection $reactions;  // Collection of ReactionEntity
    private int $reactionCount;
    private ?ReactionEntity $myReaction;
    private Collection $views;  // Collection of ViewEntity
    private int $viewCount;
    private Collection $shares;  // Collection of ShareEntity
    private int $shareCount;
    private \DateTimeImmutable $createdAt;
    private \DateTimeImmutable $updatedAt;

    // Constructor to initialize the entity
    public function __construct(
        string $attachmentId,
        string $postId,
        string $title,
        string $description,
        string $fileName,
        string $filePath,
        string $fileURL,
        string $mimeType,
        \DateTimeImmutable $createdAt,
        \DateTimeImmutable $updatedAt,
        int $reactionCount = 0,
        int $viewCount = 0,
        int $shareCount = 0,
        int $commentCount = 0,
        ?ReactionEntity $myReaction = null
    ) {
        $this->attachmentId = $attachmentId;
        $this->postId = $postId;
        $this->title = $title;
        $this->description = $description;
        $this->fileName = $fileName;
        $this->filePath = $filePath;
        $this->fileURL = $fileURL;
        $this->mimeType = $mimeType;
        $this->comments = collect();  // Initialize comments collection
        $this->commentCount = $commentCount;
        $this->reactions = collect();  // Initialize reactions collection
        $this->reactionCount = $reactionCount;
        $this->myReaction = $myReaction;
        $this->views = collect();  // Initialize views collection
        $this->viewCount = $viewCount;
        $this->shares = collect();  // Initialize shares collection
        $this->shareCount = $shareCount;
        $this->createdAt = $createdAt;
        $this->updatedAt = $updatedAt;
    }

    // Add and remove methods for the collections and entities

    public function addComment(CommentEntity $comment): void
    {
        $this->comments->push($comment);
        $this->commentCount++;
    }

    public function removeComment(CommentEntity $comment): void
    {
        if ($this->comments->contains($comment)) {
            $this->comments = $this->comments->filter(fn($c) => $c !== $comment);
            $this->commentCount--;
        }
    }

    public function addReaction(ReactionEntity $reaction): void
    {
        $this->reactions->push($reaction);
        $this->reactionCount++;
    }

    public function removeReaction(ReactionEntity $reaction): void
    {
        if ($this->reactions->contains($reaction)) {
            $this->reactions = $this->reactions->filter(fn($r) => $r !== $reaction);
            $this->reactionCount--;
        }
    }

    public function addView(ViewEntity $view): void
    {
        $this->views->push($view);
        $this->viewCount++;
    }

    public function addShare(ShareEntity $share): void
    {
        $this->shares->push($share);
        $this->shareCount++;
    }

    public function setMyReaction(?ReactionEntity $reaction): void
    {
        $this->myReaction = $reaction;
    }

    // Getters for the properties
    public function getAttachmentId(): string
    {
        return $this->attachmentId;
    }

    public function getPostId(): string
    {
        return $this->postId;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function getFileName(): string
    {
        return $this->fileName;
    }

    public function getFilePath(): string
    {
        return $this->filePath;
    }

    public function getFileURL(): string
    {
        return $this->fileURL;
    }

    public function getMimeType(): string
    {
        return $this->mimeType;
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

    public function getCreatedAt(): \DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function getUpdatedAt(): \DateTimeImmutable
    {
        return $this->updatedAt;
    }
}
