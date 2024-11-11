<?php

namespace App\Modules\Auth\Authentication\Domain\Interfaces;

use App\Modules\Auth\Authentication\Domain\Entities\UserEntity;


interface UserRepositoryInterface
{
    public function save(UserEntity $userUserModel): void;
    public function findById(string $userId): ?UserEntity;
    public function findByEmail(string $email): ?UserEntity;
}
