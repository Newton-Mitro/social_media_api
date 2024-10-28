<?php

namespace App\Modules\Auth\User\Interfaces;

use App\Modules\Auth\User\BusinessModels\UserModel;

interface UserRepositoryInterface
{
    //    public function all(): array;
    public function create(UserModel $userUserModel): UserModel;

    public function findById(string $userUserId): ?UserModel;

    public function findUserByEmail(string $email): ?UserModel;

    public function update(string $userId, UserModel $userModel): UserModel;
}
