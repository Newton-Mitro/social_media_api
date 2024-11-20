<?php

namespace App\Modules\Content\Reaction\Domain\Entities;

use App\Modules\Auth\Domain\Entities\UserEntity;
use App\Modules\Content\Reaction\Domain\ValueObjects\ReactionTypes;
use DateTimeImmutable;

class ReactionEntity
{
    private string $id;
    private string $reactableId;
    private string $reactableType;
    private UserEntity $user;
    private ReactionTypes $type;
    private DateTimeImmutable $createdAt;
    private DateTimeImmutable $updatedAt;

    public function __construct(
        string $id,
        string $reactableId,
        string $reactableType,
        UserEntity $user,
        ReactionTypes $type,
        DateTimeImmutable $createdAt,
        DateTimeImmutable $updatedAt
    ) {
        $this->id = $id;
        $this->reactableId = $reactableId;
        $this->reactableType = $reactableType;
        $this->user = $user;
        $this->type = $type;
        $this->createdAt = $createdAt;
        $this->updatedAt = $updatedAt;
    }

    // Getter methods
    public function getId(): string
    {
        return $this->id;
    }

    public function getReactableId(): string
    {
        return $this->reactableId;
    }

    public function getReactableType(): string
    {
        return $this->reactableType;
    }

    public function getUser(): UserEntity
    {
        return $this->user;
    }

    public function getType(): ReactionTypes
    {
        return $this->type;
    }

    public function getCreatedAt(): DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function getUpdatedAt(): DateTimeImmutable
    {
        return $this->updatedAt;
    }
}
