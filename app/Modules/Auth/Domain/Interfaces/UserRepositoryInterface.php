<?php

namespace App\Modules\Auth\Domain\Interfaces;

use App\Modules\Auth\Domain\Entities\UserEntity;


interface RepositoryInterface
{
    public function save(UserEntity $userUserModel): void;
    public function findById(string $userId): ?UserEntity;
    public function findByEmail(string $email): ?UserEntity;
}
