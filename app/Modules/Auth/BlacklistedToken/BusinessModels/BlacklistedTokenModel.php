<?php

namespace App\Modules\Auth\BlacklistedToken\BusinessModels;

use DateTimeImmutable;

class BlacklistedTokenModel
{
    public function __construct(
        private int $id,
        private string $token,
        private readonly DateTimeImmutable $createdAt = new DateTimeImmutable,
        private readonly DateTimeImmutable $updatedAt = new DateTimeImmutable,
    ) {}

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
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
