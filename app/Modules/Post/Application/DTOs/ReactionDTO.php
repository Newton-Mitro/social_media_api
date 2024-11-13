<?php

namespace App\Modules\Post\Domain\Entities;

use DateTimeImmutable;
use App\Modules\Post\Domain\Enums\ReactionTypes;
use App\Modules\Auth\Application\DTOs\UserDTO;

class ReactionDTO
{
    public function __construct(
        public  string $id,
        public UserDTO $reactedBy,
        public ReactionTypes $reactionType,
        public DateTimeImmutable $createdAt,
        public DateTimeImmutable $updatedAt
    ) {}
}
