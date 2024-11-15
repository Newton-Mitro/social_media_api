<?php

namespace App\Modules\Auth\Infrastructure\Repositories;

use App\Modules\Auth\Domain\Entities\UserEntity;
use App\Modules\Auth\Domain\Interfaces\RepositoryInterface;
use App\Modules\Auth\Infrastructure\Mappers\UserEntityMapper;
use App\Modules\Auth\Infrastructure\Mappers\UserModelMapper;
use App\Modules\Auth\Infrastructure\Models\User;
use Illuminate\Support\Facades\DB;

class RepositoryInterfaceImpl implements RepositoryInterface
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
