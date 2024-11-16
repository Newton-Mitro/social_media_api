<?php

namespace App\Modules\Auth\Application\Mappers;

use App\Modules\Auth\Application\DTOs\UserOtpDTO;
use App\Modules\Auth\Domain\Entities\UserOtpEntity;

use function PHPSTORM_META\type;

class UserOtpDTOMapper
{
    public static function toDTO(UserOtpEntity $entity): UserOtpDTO
    {
        return new UserOtpDTO(
            id: $entity->getId(),
            userId: $entity->getUserId(),
            type: $entity->getType(),
            expiresAt: $entity->getExpiresAt(),
            isVerified: $entity->getIsVerified(),
            otp: $entity->getOtp(),
            token: $entity->getToken(),
            createdAt: $entity->getCreatedAt(),
            updatedAt: $entity->getUpdatedAt()
        );
    }
}
