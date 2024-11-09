<?php

namespace App\Modules\Post\Domain\Entities;

use App\Modules\Auth\User\Domain\Entities\UserEntity;

class ShareEntity
{
    private string $id;
    private UserEntity $sharer; // User who shared the post
    private string $platform;   // Platform on which the post was shared (e.g., Facebook, Twitter)
    private \DateTimeImmutable $sharedAt; // Time when the post was shared

    // Constructor to initialize the ShareEntity
    public function __construct(
        string $id,
        UserEntity $sharer,
        string $platform,
        \DateTimeImmutable $sharedAt
    ) {
        $this->id = $id;
        $this->sharer = $sharer;
        $this->platform = $platform;
        $this->sharedAt = $sharedAt;
    }

    // Getters for the properties
    public function getId(): string
    {
        return $this->id;
    }

    public function getSharer(): UserEntity
    {
        return $this->sharer;
    }

    public function getPlatform(): string
    {
        return $this->platform;
    }

    public function getSharedAt(): \DateTimeImmutable
    {
        return $this->sharedAt;
    }
}
