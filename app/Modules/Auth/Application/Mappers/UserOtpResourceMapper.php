<?php

namespace App\Modules\Auth\Application\Mappers;

use App\Modules\Auth\Application\Resources\UserOtpResource;
use App\Modules\Auth\Domain\Entities\UserOtpEntity;

class UserOtpResourceMapper
{
    public static function toResource(UserOtpEntity $entity): UserOtpResource
    {
        return new UserOtpResource(
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
