<?php

namespace App\Features\Auth\User\UseCases\Commands\CreateUser;

use App\Core\Bus\Command;

class CreateUserCommand extends Command
{
    public function __construct(
        private readonly string $name,
        private readonly string $userName,
        private readonly string $email,
        private readonly string $password,
        private readonly ?string $profilePicture = null,
        private readonly ?string $coverPhoto = null,
        private readonly ?string $emailVerifiedAt = null,
        private readonly ?string $otp = null,
        private readonly ?string $otpExpiresAt = null,
        private readonly bool $otpVerified = false,
        private readonly ?string $lastLoggedIn = null,
    ) {}

    public function getName(): string
    {
        return $this->name;
    }

    public function getUserName(): string
    {
        return $this->userName;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function getProfilePicture(): ?string
    {
        return $this->profilePicture;
    }

    public function getCoverPhoto(): ?string
    {
        return $this->coverPhoto;
    }

    public function getEmailVerifiedAt(): ?string
    {
        return $this->emailVerifiedAt;
    }

    public function getOtp(): ?string
    {
        return $this->otp;
    }

    public function getOtpExpiresAt(): ?string
    {
        return $this->otpExpiresAt;
    }

    public function isOtpVerified(): bool
    {
        return $this->otpVerified;
    }

    public function getLastLoggedIn(): ?string
    {
        return $this->lastLoggedIn;
    }
}
