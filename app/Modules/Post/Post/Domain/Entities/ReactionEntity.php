<?php

namespace App\Modules\Post\Domain\Entities;

use App\Core\Entities\BaseEntity;
use App\Modules\Auth\Domain\Entities\UserEntity;
use App\Modules\Post\Domain\Enums\ReactionTypes;
use DateTimeImmutable;

class ReactionEntity extends BaseEntity
{
    private UserEntity $reactedBy;
    private ReactionTypes $reactionType;
    private DateTimeImmutable $createdAt;
    private DateTimeImmutable $updatedAt;

    public function __construct(

        UserEntity $reactedBy,
        ReactionTypes $reactionType,
        DateTimeImmutable $createdAt = new DateTimeImmutable(),
        DateTimeImmutable $updatedAt = new DateTimeImmutable(),
        ?string $id = null
    ) {
        parent::__construct($id);
        $this->reactedBy = $reactedBy;
        $this->reactionType = $reactionType;
        $this->createdAt = $createdAt;
        $this->updatedAt = $updatedAt;
    }

    public function getReactedBy(): UserEntity
    {
        return $this->reactedBy;
    }

    public function getReactionType(): ReactionTypes
    {
        return $this->reactionType;
    }

    public function getCreatedAt(): DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function getUpdatedAt(): DateTimeImmutable
    {
        return $this->updatedAt;
    }

    public function updateReactionType(ReactionTypes $newReactionType): void
    {
        $this->reactionType = $newReactionType;
        $this->updatedAt = new DateTimeImmutable();
    }
}
