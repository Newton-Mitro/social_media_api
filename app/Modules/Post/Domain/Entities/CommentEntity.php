<?php

namespace App\Modules\Post\Domain\Entities;

use App\Modules\Auth\Domain\Entities\UserEntity;
use DateTimeImmutable;

class CommentEntity
{
    private string $id;
    private string $postId;
    private UserEntity $author;
    private string $commentText;
    private string $commentableId;
    private string $commentableType;
    private ?string $parentId;
    private DateTimeImmutable $createdAt;
    private DateTimeImmutable $updatedAt;

    public function __construct(
        string $id,
        string $postId,
        UserEntity $author,
        string $commentText,
        string $commentableId,
        string $commentableType,
        ?string $parentId = null,
        ?DateTimeImmutable $createdAt = null,
        ?DateTimeImmutable $updatedAt = null
    ) {
        $this->id = $id;
        $this->postId = $postId;
        $this->author = $author;
        $this->commentText = $commentText;
        $this->commentableId = $commentableId;
        $this->commentableType = $commentableType;
        $this->parentId = $parentId;
        $this->createdAt = $createdAt ?? new DateTimeImmutable();
        $this->updatedAt = $updatedAt ?? new DateTimeImmutable();
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getPostId(): string
    {
        return $this->postId;
    }

    public function getAuthor(): UserEntity
    {
        return $this->author;
    }

    public function getCommentText(): string
    {
        return $this->commentText;
    }

    public function getCommentableId(): string
    {
        return $this->commentableId;
    }

    public function getCommentableType(): string
    {
        return $this->commentableType;
    }

    public function getParentId(): ?string
    {
        return $this->parentId;
    }

    public function getCreatedAt(): DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function getUpdatedAt(): DateTimeImmutable
    {
        return $this->updatedAt;
    }

    public function updateCommentText(string $newContent): void
    {
        $this->commentText = $newContent;
        $this->updatedAt = new DateTimeImmutable();
    }

    public function isTopLevel(): bool
    {
        return $this->parentId === null;
    }
}
