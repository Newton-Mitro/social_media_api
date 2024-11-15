<?php

namespace App\Modules\Profile\Application\DTOs;

use App\Modules\Profile\Domain\Entities\ProfileEntity;
use DateTimeImmutable;

class ProfileDTO
{
    public string $id;
    public string $userId;
    public ?string $sex;
    public ?DateTimeImmutable $dbo;
    public ?string $mobileNumber;
    public ?string $profilePicture;
    public ?string $coverPhoto;
    public ?string $bio;
    public DateTimeImmutable $createdAt;
    public DateTimeImmutable $updatedAt;

    public function __construct(
        string $id,
        string $userId,
        ?string $sex,
        ?DateTimeImmutable $dbo,
        ?string $mobileNumber,
        ?string $profilePicture,
        ?string $coverPhoto,
        ?string $bio,
        DateTimeImmutable $createdAt,
        DateTimeImmutable $updatedAt
    ) {
        $this->id = $id;
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

    public static function fromEntity(ProfileEntity $profile): self
    {
        return new self(
            $profile->getId(),
            $profile->getUserId(),
            $profile->getSex(),
            $profile->getDbo(),
            $profile->getMobileNumber(),
            $profile->getProfilePicture(),
            $profile->getCoverPhoto(),
            $profile->getBio(),
            $profile->getCreatedAt(),
            $profile->getUpdatedAt()
        );
    }
}
