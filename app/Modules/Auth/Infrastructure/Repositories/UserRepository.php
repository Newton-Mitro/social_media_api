<?php

namespace App\Modules\Auth\Infrastructure\Repositories;

use App\Modules\Auth\Domain\Aggregates\UserAggregate;
use App\Modules\Auth\Domain\Interfaces\UserRepositoryInterface;
use App\Modules\Auth\Infrastructure\Mappers\UserAggregateMapper;
use App\Modules\Auth\Infrastructure\Models\User;

class UserRepository implements UserRepositoryInterface
{
    public function findById(string $userId): ?UserAggregate
    {
        $user = User::with('profile')->find($userId);
        if ($user) {
            return UserAggregateMapper::toAggregate($user);
        }

        return null;
    }

    public function findByEmail(string $email): ?UserAggregate
    {
        $user = User::with('profile')->where('email', $email)->first();
        if ($user) {
            return UserAggregateMapper::toAggregate($user);
        }

        return null;
    }

    public function save(UserAggregate $userEntity): void
    {
        $user = UserAggregateMapper::toModel($userEntity);
        $user->save();
    }
}
