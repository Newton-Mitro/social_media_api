<?php

namespace App\Modules\Auth\Authentication\Infrastructure\Repositories;

use App\Modules\Auth\Authentication\Domain\Entities\UserEntity;
use App\Modules\Auth\Authentication\Domain\Interfaces\UserRepositoryInterface;
use App\Modules\Auth\Authentication\Infrastructure\Mappers\UserEntityMapper;
use App\Modules\Auth\Authentication\Infrastructure\Mappers\UserModelMapper;
use App\Modules\Auth\Authentication\Infrastructure\Models\User;
use Illuminate\Support\Facades\DB;

class UserRepositoryInterfaceImpl implements UserRepositoryInterface
{
    public function findById(string $userId): ?UserEntity
    {
        $user = User::find($userId);
        if ($user) {
            return UserEntityMapper::toEntity($user);
        }

        return null;
    }

    public function findByEmail(string $email): ?UserEntity
    {
        $user = User::where('email', $email)->first();
        if ($user) {
            return UserEntityMapper::toEntity($user);
        }

        return null;
    }

    public function save(UserEntity $userEntity): void
    {
        DB::transaction(function () use ($userEntity) {
            $user = UserModelMapper::toModel($userEntity);
            $user->save();
        });
    }
}
