<?php

namespace App\Modules\Post\Domain\Entities;

class ReactionResource
{
    public function __construct(
        public  string $id,
        public string $userId,
        public string $reactionType,
        public \DateTimeImmutable $createdAt,
        public \DateTimeImmutable $updatedAt
    ) {}
}
