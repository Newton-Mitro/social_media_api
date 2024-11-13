<?php

namespace App\Modules\Post\Domain\Entities;

use App\Modules\Auth\Domain\Entities\UserEntity;
use DateTimeImmutable;

class CommentEntity
{
    private string $id;
    private string $postId;
    private UserEntity $author;
    private string $content;
    private DateTimeImmutable $createdAt;
    private DateTimeImmutable $updatedAt;

    public function __construct(string $id, string $postId, UserEntity $author, string $content)
    {
        $this->id = $id;
        $this->postId = $postId;
        $this->author = $author;
        $this->content = $content;
        $this->createdAt = new DateTimeImmutable();
        $this->updatedAt = new DateTimeImmutable();
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

    public function getContent(): string
    {
        return $this->content;
    }

    public function getCreatedAt(): DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function getUpdatedAt(): DateTimeImmutable
    {
        return $this->updatedAt;
    }

    public function updateContent(string $newContent): void
    {
        $this->content = $newContent;
        $this->updatedAt = new DateTimeImmutable(); // Update the timestamp
    }
}
