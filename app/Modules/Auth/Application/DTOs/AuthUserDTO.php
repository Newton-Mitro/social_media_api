<?php

namespace App\Modules\Auth\Application\DTOs;


class AuthUserDTO
{
    public function __construct(
        public UserDTO $user,
        public string $access_token,
        public string $refresh_token,
    ) {}
}
