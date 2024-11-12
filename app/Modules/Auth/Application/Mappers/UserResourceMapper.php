<?php

namespace App\Modules\Auth\Application\Mappers;

use App\Modules\Auth\Application\Resources\UserResource;
use App\Modules\Auth\Domain\Entities\UserEntity;

class UserResourceMapper
{
    public static function toResource(UserEntity $entity): UserResource
    {
        return new UserResource(
            id: $entity->getId(),
            name: $entity->getName(),
            username: $entity->getUserName(),
            email: $entity->getEmail(),
            account_verified: $entity->getEmailVerifiedAt() ? true : false,
            profile_picture: $entity->getProfilePicture(),
            cover_photo: $entity->getCoverPhoto()
        );
    }
}
