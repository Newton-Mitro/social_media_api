<?php

namespace App\Features\Auth\BlacklistedToken\UseCases\Commands\AddBlackListToken;

use App\Core\Bus\Command;

class AddTokenToBlackListCommand extends Command
{
    public function __construct(
        private readonly string $token,
    ) {}

    public function getToken(): string
    {
        return $this->token;
    }
}
