<?php

namespace App\Modules\Post\Domain\Entities;

class CommentEntity
{
    private string $id;
    private string $postId;
    private string $authorId;
    private string $content;
    private \DateTimeImmutable $createdAt;
    private \DateTimeImmutable $updatedAt;

    public function __construct(string $id, string $postId, string $authorId, string $content)
    {
        $this->id = $id;
        $this->postId = $postId;
        $this->authorId = $authorId;
        $this->content = $content;
        $this->createdAt = new \DateTimeImmutable();
        $this->updatedAt = new \DateTimeImmutable();
    }

    public function getId(): string
    {
        return $this->id;
    }
}
