<?php

namespace App\Features\Auth\User\Interfaces;

use App\Features\Auth\User\BusinessModels\UserModel;

interface UserRepositoryInterface
{
    //    public function all(): array;
    public function create(UserModel $userUserModel): UserModel;

    public function findById(int $userUserId): ?UserModel;

    public function findUserByEmail(string $email): ?UserModel;

    public function update(int $userId, UserModel $userModel): UserModel;
}
