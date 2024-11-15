<?php

namespace App\Modules\Auth\Infrastructure\Mappers;

use App\Modules\Auth\Domain\Entities\UserEntity;
use App\Modules\Auth\Infrastructure\Models\User;

class UserModelMapper
{
    public static function toModel(UserEntity $entity): User
    {
        $user = User::find($entity->getId()) ?? new User();
        $user->name = $entity->getName();
        $user->email = $entity->getEmail();
        $user->password = $entity->getPassword();
        $user->email_verified_at = $entity->getEmailVerifiedAt();
        $user->last_logged_in = $entity->getLastLoggedIn();
        $user->created_at = $entity->getCreatedAt();
        $user->updated_at = $entity->getUpdatedAt();

        return $user;
    }
}
