<?php

namespace App\Modules\Content\Reaction\Application\DTOs;

use App\Modules\Auth\Application\DTOs\UserDTO;
use App\Modules\Content\Reaction\Domain\ValueObjects\ReactionTypes;
use DateTimeImmutable;

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
