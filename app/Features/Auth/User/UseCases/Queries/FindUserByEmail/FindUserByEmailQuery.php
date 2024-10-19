<?php

namespace App\Features\Auth\User\UseCases\Queries\FindUserByEmail;

use App\Core\Bus\Query;

class FindUserByEmailQuery extends Query
{
    public function __construct(
        private readonly string $email,
    ) {}

    public function getEmail(): string
    {
        return $this->email;
    }
}
