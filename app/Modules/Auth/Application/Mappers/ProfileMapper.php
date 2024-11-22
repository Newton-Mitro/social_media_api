<?php

namespace App\Modules\Auth\Application\Mappers;

use App\Modules\Auth\Application\DTOs\ProfileDTO;
use App\Modules\Auth\Domain\Entities\ProfileEntity;
use Illuminate\Support\Facades\Storage;

class ProfileMapper
{
    public static function toDTO(?ProfileEntity $profileEntity): ProfileDTO
    {
        return new ProfileDTO(
            id: $profileEntity->getId(),
            user_id: $profileEntity->getUserId(),
            sex: $profileEntity->getSex(),
            dbo: $profileEntity->getDbo()?->format('Y-m-d'),
            mobile_number: $profileEntity->getMobileNumber(),
            profile_picture: asset(Storage::url($profileEntity->getProfilePicture())),
            cover_photo: asset(Storage::url($profileEntity->getCoverPhoto())),
            bio: $profileEntity->getBio(),
            created_at: $profileEntity->getCreatedAt()->format('Y-m-d H:i:s'),
            updated_at: $profileEntity->getUpdatedAt()->format('Y-m-d H:i:s')
        );
    }
}
