<?php

namespace App\Features\Auth\User\BusinessModels;

use DateTimeImmutable;

class UserModel
{
    public function __construct(
        private int $userId,
        private string $name,
        private string $userName,
        private string $email,
        private ?string $password = null,
        private ?string $profilePicture = null,
        private ?string $coverPhoto = null,
        private ?DateTimeImmutable $emailVerifiedAt = null,
        private ?string $otp = null,
        private ?DateTimeImmutable $otpExpiresAt = null,
        private bool $otpVerified = false,
        private ?DateTimeImmutable $lastLoggedIn = null,
        private DateTimeImmutable $createdAt = new DateTimeImmutable,
        private DateTimeImmutable $updatedAt = new DateTimeImmutable
    ) {}

    public function getUserId(): int
    {
        return $this->userId;
    }

    public function setUserId(int $userId): void
    {
        $this->userId = $userId;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getUserName(): string
    {
        return $this->userName;
    }

    public function setUserName(string $userName): void
    {
        $this->userName = $userName;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(?string $password): void
    {
        $this->password = $password;
    }

    public function getProfilePicture(): ?string
    {
        return $this->profilePicture;
    }

    public function setProfilePicture(?string $profilePicture): void
    {
        $this->profilePicture = $profilePicture;
    }

    public function getCoverPhoto(): ?string
    {
        return $this->coverPhoto;
    }

    public function setCoverPhoto(?string $coverPhoto): void
    {
        $this->coverPhoto = $coverPhoto;
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

    public function getOtp(): ?string
    {
        return $this->otp;
    }

    public function setOtp(?string $otp): void
    {
        $this->otp = $otp;
    }

    public function getOtpExpiresAt(): ?DateTimeImmutable
    {
        return $this->otpExpiresAt;
    }

    public function setOtpExpiresAt(?DateTimeImmutable $otpExpiresAt): void
    {
        $this->otpExpiresAt = $otpExpiresAt;
    }

    public function isOtpVerified(): bool
    {
        return $this->otpVerified;
    }

    public function setOtpVerified(bool $otpVerified): void
    {
        $this->otpVerified = $otpVerified;
    }

    public function getLastLoggedIn(): ?DateTimeImmutable
    {
        return $this->lastLoggedIn;
    }

    public function setLastLoggedIn(?DateTimeImmutable $lastLoggedIn): void
    {
        $this->lastLoggedIn = $lastLoggedIn;
    }
}
