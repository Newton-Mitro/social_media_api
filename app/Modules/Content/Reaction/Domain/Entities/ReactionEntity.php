<?php

namespace App\Modules\Content\Reaction\Domain\Entities;

use App\Modules\Auth\Domain\Entities\UserAggregate;
use App\Modules\Content\Reaction\Domain\ValueObjects\ReactionTypes;
use DateTimeImmutable;

class ReactionEntity
{
    private string $id;
    private string $reactableId;
    private string $reactableType;
    private string $userId;
    private ReactionTypes $type;
    private DateTimeImmutable $createdAt;
    private DateTimeImmutable $updatedAt;

    public function __construct(
        string $id,
        string $reactableId,
        string $reactableType,
        string $userId,
        ReactionTypes $type,
        DateTimeImmutable $createdAt,
        DateTimeImmutable $updatedAt
    ) {
        $this->id = $id;
        $this->reactableId = $reactableId;
        $this->reactableType = $reactableType;
        $this->userId = $userId;
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

    public function getUserId(): string
    {
        return $this->userId;
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
