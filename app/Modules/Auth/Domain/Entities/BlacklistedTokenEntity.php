<?php

namespace App\Modules\Auth\Domain\Entities;

use App\Core\Entities\BaseEntity;
use DateTimeImmutable;

class BlacklistedTokenEntity extends BaseEntity
{
    public function __construct(
        private string $token,
        private readonly DateTimeImmutable $createdAt = new DateTimeImmutable,
        private readonly DateTimeImmutable $updatedAt = new DateTimeImmutable,
        protected ?string $id = null,
    ) {
        parent::__construct($id);
    }


    public function getToken(): string
    {
        return $this->token;
    }

    public function getCreatedAt(): DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function getUpdatedAt(): DateTimeImmutable
    {
        return $this->updatedAt;
    }

    public function setToken(string $token): void
    {
        $this->token = $token;
    }
}
