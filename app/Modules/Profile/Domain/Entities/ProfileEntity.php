<?php

namespace App\Modules\Profile\Domain\Entities;

use App\Core\Entities\BaseEntity;
use DateTimeImmutable;

class ProfileEntity extends BaseEntity
{
    private string $userId;
    private ?string $sex;
    private ?DateTimeImmutable $dbo;
    private ?string $mobileNumber;
    private ?string $profilePicture;
    private ?string $coverPhoto;
    private ?string $bio;
    private DateTimeImmutable $createdAt;
    private DateTimeImmutable $updatedAt;

    public function __construct(

        string $userId,
        ?string $sex,
        ?DateTimeImmutable $dbo,
        ?string $mobileNumber,
        ?string $profilePicture,
        ?string $coverPhoto,
        ?string $bio,
        DateTimeImmutable $createdAt,
        DateTimeImmutable $updatedAt,
        ?string $id = null
    ) {
        parent::__construct($id);
        $this->userId = $userId;
        $this->sex = $sex;
        $this->dbo = $dbo;
        $this->mobileNumber = $mobileNumber;
        $this->profilePicture = $profilePicture;
        $this->coverPhoto = $coverPhoto;
        $this->bio = $bio;
        $this->createdAt = $createdAt;
        $this->updatedAt = $updatedAt;
    }

    // Getters
    public function getUserId(): string
    {
        return $this->userId;
    }

    public function getSex(): ?string
    {
        return $this->sex;
    }

    public function getDbo(): ?DateTimeImmutable
    {
        return $this->dbo;
    }

    public function getMobileNumber(): ?string
    {
        return $this->mobileNumber;
    }

    public function getProfilePicture(): ?string
    {
        return $this->profilePicture;
    }

    public function getCoverPhoto(): ?string
    {
        return $this->coverPhoto;
    }

    public function getBio(): ?string
    {
        return $this->bio;
    }

    public function getCreatedAt(): DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function getUpdatedAt(): DateTimeImmutable
    {
        return $this->updatedAt;
    }

    // Business Logic
    public function updateProfile(
        ?string $mobileNumber,
        ?string $profilePicture,
        ?string $coverPhoto,
        ?string $bio
    ): void {
        $this->mobileNumber = $mobileNumber;
        $this->profilePicture = $profilePicture;
        $this->coverPhoto = $coverPhoto;
        $this->bio = $bio;
        $this->updatedAt = new DateTimeImmutable();
    }
}
