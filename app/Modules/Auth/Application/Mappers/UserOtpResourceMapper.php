<?php

namespace App\Modules\Auth\Application\Mappers;

use App\Modules\Auth\Application\DTOs\UserOtpDTO;
use App\Modules\Auth\Domain\Entities\UserOtpEntity;

class UserOtpDTOMapper
{
    public static function toDTO(UserOtpEntity $entity): UserOtpDTO
    {
        return new UserOtpDTO(
            id: $entity->getId(),
            otp: $entity->getOtp(),
            userId: $entity->getUserId(),
            expiresAt: $entity->getExpiresAt(),
            isVerified: $entity->getIsVerified(),
            token: $entity->getToken(),
            createdAt: $entity->getCreatedAt(),
            updatedAt: $entity->getUpdatedAt()
        );
    }
}
