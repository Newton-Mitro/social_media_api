<?php

namespace App\Modules\Auth\Domain\Aggregates;

use App\Core\Entities\BaseEntity;
use App\Modules\Auth\Domain\Entities\ProfileEntity;
use DateTimeImmutable;

class UserAggregate extends BaseEntity
{
    public function __construct(
        protected ?string $id = null,
        private string $name,
        private string $email,
        private string $password,
        private ?DateTimeImmutable $emailVerifiedAt = null,
        private ?DateTimeImmutable $lastLoggedIn = null,
        private DateTimeImmutable $createdAt = new DateTimeImmutable(),
        private DateTimeImmutable $updatedAt = new DateTimeImmutable(),
        private ProfileEntity $profile
    ) {
        parent::__construct($id);
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): void
    {
        $this->password = $password;
    }

    public function getCreatedAt(): DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(DateTimeImmutable $createdAt): void
    {
        $this->createdAt = $createdAt;
    }

    public function getUpdatedAt(): DateTimeImmutable
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(DateTimeImmutable $updatedAt): void
    {
        $this->updatedAt = $updatedAt;
    }

    public function getEmailVerifiedAt(): ?DateTimeImmutable
    {
        return $this->emailVerifiedAt;
    }

    public function setEmailVerifiedAt(?DateTimeImmutable $emailVerifiedAt): void
    {
        $this->emailVerifiedAt = $emailVerifiedAt;
    }

    public function getLastLoggedIn(): ?DateTimeImmutable
    {
        return $this->lastLoggedIn;
    }

    public function setLastLoggedIn(?DateTimeImmutable $lastLoggedIn): void
    {
        $this->lastLoggedIn = $lastLoggedIn;
    }

    public function getProfile(): ProfileEntity
    {
        return $this->profile;
    }

    public function setProfile(ProfileEntity $profile): void
    {
        $this->profile = $profile;
    }
}
