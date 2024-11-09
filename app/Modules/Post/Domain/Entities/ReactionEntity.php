<?php

namespace App\Modules\Post\Domain\Entities;

class ReactionEntity
{
    private string $id;         // Unique ID for the reaction
    private string $userId;     // ID of the user who reacted
    private string $reactionType; // Type of reaction (e.g., "like", "love", "angry", etc.)
    private \DateTimeImmutable $createdAt; // Date and time when the reaction was created
    private \DateTimeImmutable $updatedAt; // Date and time when the reaction was last updated

    // Constructor to initialize the entity
    public function __construct(
        string $id,
        string $userId,
        string $reactionType,
        \DateTimeImmutable $createdAt,
        \DateTimeImmutable $updatedAt
    ) {
        $this->id = $id;
        $this->userId = $userId;
        $this->reactionType = $reactionType;
        $this->createdAt = $createdAt;
        $this->updatedAt = $updatedAt;
    }

    // Getter methods for each property
    public function getId(): string
    {
        return $this->id;
    }

    public function getUserId(): string
    {
        return $this->userId;
    }

    public function getReactionType(): string
    {
        return $this->reactionType;
    }

    public function getCreatedAt(): \DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function getUpdatedAt(): \DateTimeImmutable
    {
        return $this->updatedAt;
    }

    // Method to update the reaction type (if allowed)
    public function updateReactionType(string $reactionType): void
    {
        $this->reactionType = $reactionType;
        $this->updatedAt = new \DateTimeImmutable(); // Update the timestamp on change
    }
}
