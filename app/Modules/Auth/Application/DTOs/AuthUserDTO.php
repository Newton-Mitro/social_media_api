<?php

namespace App\Modules\Auth\Application\DTOs;

use App\Modules\Auth\Application\DTOs\UserAggregateDTO;

class AuthUserDTO
{
    public function __construct(
        public UserAggregateDTO $user,
        public string $access_token,
        public string $refresh_token,
    ) {}
}
