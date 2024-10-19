<?php

namespace App\Features\Auth\BlacklistedToken\UseCases\Queries\BlackListTokenExist;

use App\Core\Bus\Query;

class BlacklistedTokenExistQuery extends Query
{
    public function __construct(
        private readonly string $token
    ) {}

    public function getToken(): string
    {
        return $this->token;
    }
}
