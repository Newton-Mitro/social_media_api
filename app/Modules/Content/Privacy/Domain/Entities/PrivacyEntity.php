<?php

namespace App\Modules\Content\Privacy\Domain\Entities;

use App\Core\Entities\BaseEntity;
use DateTimeImmutable;

class PrivacyEntity extends BaseEntity
{
    private string $privacyName;
    private \DateTimeImmutable $createdAt;
    private \DateTimeImmutable $updatedAt;

    public function __construct(
        string $id,
        string $privacyName,
        DateTimeImmutable $createdAt = new DateTimeImmutable(),
        DateTimeImmutable $updatedAt = new DateTimeImmutable()
    ) {
        parent::__construct($id);
        $this->privacyName = $privacyName;
        $this->createdAt = $createdAt;
        $this->updatedAt = $updatedAt;
    }

    public function getPrivacyName(): string
    {
        return $this->privacyName;
    }

    public function getCreatedAt(): \DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function getUpdatedAt(): \DateTimeImmutable
    {
        return $this->updatedAt;
    }
}
