<?php

namespace App\Modules\Auth\Authentication\Application\Mappers;

use App\Modules\Auth\Authentication\Application\Resources\UserOtpResource;
use App\Modules\Auth\Authentication\Domain\Entities\UserOtpEntity;

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
