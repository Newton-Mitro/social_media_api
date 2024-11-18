<?php

namespace App\Modules\Profile\Application\Mappers;

use App\Modules\Profile\Domain\Entities\ProfileEntity;
use App\Modules\Profile\Application\DTOs\ProfileDTO;

class ProfileDTOMapper
{
    public static function fromEntity(?ProfileEntity $profileEntity): ProfileDTO
    {
        if (!$profileEntity) {
            return new ProfileDTO(
                id: null,
                user_id: '',
                sex: null,
                dbo: null,
                mobile_number: null,
                profile_picture: null,
                cover_photo: null,
                bio: null,
                created_at: '',
                updated_at: ''
            );
        }

        return new ProfileDTO(
            id: $profileEntity->getId(),
            user_id: $profileEntity->getUserId(),
            sex: $profileEntity->getSex(),
            dbo: $profileEntity->getDbo()?->format('Y-m-d'),
            mobile_number: $profileEntity->getMobileNumber(),
            profile_picture: $profileEntity->getProfilePicture(),
            cover_photo: $profileEntity->getCoverPhoto(),
            bio: $profileEntity->getBio(),
            created_at: $profileEntity->getCreatedAt()->format('Y-m-d H:i:s'),
            updated_at: $profileEntity->getUpdatedAt()->format('Y-m-d H:i:s')
        );
    }
}
