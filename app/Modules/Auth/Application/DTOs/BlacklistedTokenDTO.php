<?php

namespace App\Modules\Auth\Application\DTOs;


class BlacklistedTokenDTO
{
    public function __construct(
        public string $id,
        public string $token,
    ) {}
}
