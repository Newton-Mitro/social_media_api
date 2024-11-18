<?php

namespace App\Modules\Profile\Infrastructure\Mappers;

use App\Modules\Profile\Domain\Entities\ProfileEntity;
use App\Modules\Profile\Infrastructure\Models\Profile;

class ProfileModelMapper
{
    public static function fromEntity(ProfileEntity $entity): Profile
    {
        $model = Profile::find($entity->getId()) ?? new Profile();
        $model->id = $entity->getId();
        $model->user_id = $entity->getUserId();
        $model->sex = $entity->getSex();
        $model->dbo = $entity->getDbo();
        $model->mobile_number = $entity->getMobileNumber();
        $model->profile_picture = $entity->getProfilePicture();
        $model->cover_photo = $entity->getCoverPhoto();
        $model->bio = $entity->getBio();
        $model->created_at = $entity->getCreatedAt();
        $model->updated_at = $entity->getUpdatedAt();

        return $model;
    }
}
