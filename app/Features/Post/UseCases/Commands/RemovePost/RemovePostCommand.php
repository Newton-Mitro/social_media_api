<?php

namespace App\Features\Post\UseCases\Commands\RemovePost;

use App\Core\Bus\Command;
use App\Features\Post\Models\Post;
use DateTimeImmutable;

class RemovePostCommand extends Command
{
    public function __construct(
        private readonly int               $postId,
        private readonly Post         $postModel,
        private readonly DateTimeImmutable $createdAt = new DateTimeImmutable(),
        private readonly DateTimeImmutable $updatedAt = new DateTimeImmutable()
    ) {}

    public function getPostId(): int
    {
        return $this->postId;
    }

    public function getCreatedAt(): DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function getUpdatedAt(): DateTimeImmutable
    {
        return $this->updatedAt;
    }
    
    public function getPostModel(): Post
    {
        return $this->postModel;
    }
}
