<?php

namespace App\Modules\Auth\Domain\Interfaces;

use App\Modules\Auth\Domain\Aggregates\UserAggregate;

interface UserRepositoryInterface
{
    public function save(UserAggregate $userUserModel): void;
    public function findById(string $userId): ?UserAggregate;
    public function findByEmail(string $email): ?UserAggregate;
}
