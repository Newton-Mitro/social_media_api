<?php

namespace App\Modules\Auth\User\Interfaces;

use App\Modules\Auth\User\BusinessModels\UserEntity;

interface UserRepositoryInterface
{
    //    public function all(): array;
    public function create(UserEntity $userUserModel): UserEntity;

    public function findById(string $userUserId): ?UserEntity;

    public function findUserByEmail(string $email): ?UserEntity;

    public function update(string $userId, UserEntity $userModel): UserEntity;
}
