<?php

namespace App\Modules\Auth\Infrastructure\Mappers;

use App\Modules\Auth\Domain\Entities\UserEntity;
use App\Modules\Auth\Infrastructure\Models\User;

class UserModelMapper
{
    public static function toModel(UserEntity $entity): User
    {
        $model = User::find($entity->getId()) ?? new User();
        $model->id = $entity->getId();
        $model->name = $entity->getName();
        $model->email = $entity->getEmail();
        $model->password = $entity->getPassword();
        $model->email_verified_at = $entity->getEmailVerifiedAt();
        $model->last_logged_in = $entity->getLastLoggedIn();
        $model->created_at = $entity->getCreatedAt();
        $model->updated_at = $entity->getUpdatedAt();

        return $model;
    }
}
