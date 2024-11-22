<?php

namespace App\Modules\Auth\Infrastructure\Mappers;

use App\Modules\Auth\Domain\Entities\ProfileEntity;
use App\Modules\Profile\Infrastructure\Models\Profile;
use DateTimeImmutable;

class ProfileMapper
{
    public static function toModel(ProfileEntity $entity): Profile
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

    public static function toEntity(Profile $model): ProfileEntity
    {
        return new ProfileEntity(
            id: $model->id,
            userId: $model->user_id,
            sex: $model->sex,
            dbo: new DateTimeImmutable($model->dbo),
            mobileNumber: $model->mobile_number,
            profilePicture: $model->profile_picture,
            coverPhoto: $model->cover_photo,
            bio: $model->bio,
            createdAt: new DateTimeImmutable($model->created_at),
            updatedAt: new DateTimeImmutable($model->updated_at)
        );
    }
}
