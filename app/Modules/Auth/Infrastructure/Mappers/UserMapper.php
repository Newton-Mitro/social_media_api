<?php

namespace App\Modules\Auth\Infrastructure\Mappers;


use App\Modules\Auth\Domain\Entities\UserEntity;
use App\Modules\Auth\Infrastructure\Models\User;
use DateTimeImmutable;

class UserMapper
{
    public static function toEntity(User $model): UserEntity
    {
        return new UserEntity(
            id: $model->id,
            name: $model->name,
            email: $model->email,
            password: $model->password,
            emailVerifiedAt: $model->email_verified_at ? new DateTimeImmutable($model->email_verified_at) : null,
            lastLoggedIn: $model->last_logged_in ? new DateTimeImmutable($model->last_logged_in) : null,
            createdAt: new DateTimeImmutable($model->created_at),
            updatedAt: new DateTimeImmutable($model->updated_at)
        );
    }

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
