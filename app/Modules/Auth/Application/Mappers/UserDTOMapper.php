<?php

namespace App\Modules\Auth\Application\Mappers;

use App\Modules\Auth\Application\DTOs\UserDTO;
use App\Modules\Auth\Domain\Entities\UserEntity;

class UserDTOMapper
{
    public static function toDTO(UserEntity $entity): UserDTO
    {
        return new UserDTO(
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