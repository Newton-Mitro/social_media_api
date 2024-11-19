<?php

namespace App\Modules\Content\Share\Domain\Entities;

use App\Core\Entities\BaseEntity;
use App\Modules\Auth\Domain\Entities\UserEntity;
use App\Modules\Content\Share\Domain\ValueObjects\SharePlatforms;
use DateTimeImmutable;

class ShareEntity extends BaseEntity
{
    private UserEntity $sharer;
    private SharePlatforms $platform;
    private DateTimeImmutable $sharedAt;

    public function __construct(

        UserEntity $sharer,
        SharePlatforms $platform,
        DateTimeImmutable $sharedAt,
        ?string $id = null
    ) {
        parent::__construct($id);
        $this->sharer = $sharer;
        $this->platform = $platform;
        $this->sharedAt = $sharedAt;
    }

    // Getters for the properties

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
