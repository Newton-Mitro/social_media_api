<?php

namespace App\Modules\Auth\Infrastructure\Repositories;

use App\Modules\Auth\Domain\Entities\UserEntity;
use App\Modules\Auth\Domain\Interfaces\UserRepositoryInterface;
use App\Modules\Auth\Infrastructure\Mappers\UserMapper;
use App\Modules\Auth\Infrastructure\Models\User;

class UserRepository implements UserRepositoryInterface
{
    public function findById(string $userId): ?UserEntity
    {
        $user = User::find($userId);
        if ($user) {
            return UserMapper::toEntity($user);
        }

        return null;
    }

    public function findByEmail(string $email): ?UserEntity
    {
        $user = User::where('email', $email)->first();
        if ($user) {
            return UserMapper::toEntity($user);
        }

        return null;
    }

    public function save(UserEntity $userEntity): void
    {
        $user = UserMapper::toModel($userEntity);
        $user->save();
    }
}
