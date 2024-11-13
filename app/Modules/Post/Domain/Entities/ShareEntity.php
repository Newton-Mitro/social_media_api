<?php

namespace App\Modules\Post\Domain\Entities;

use App\Modules\Auth\Domain\Entities\UserEntity;
use App\Modules\Post\Domain\Enums\SharePlatforms;
use DateTimeImmutable;

class ShareEntity
{
    private string $id;
    private UserEntity $sharer;
    private SharePlatforms $platform;
    private DateTimeImmutable $sharedAt;

    public function __construct(
        string $id,
        UserEntity $sharer,
        SharePlatforms $platform,
        DateTimeImmutable $sharedAt
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

    public function getPlatform(): SharePlatforms
    {
        return $this->platform;
    }

    public function getSharedAt(): DateTimeImmutable
    {
        return $this->sharedAt;
    }
}
