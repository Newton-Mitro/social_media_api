<?php

namespace App\Modules\Auth\Authentication\Application\Resources;


class AuthUserResource
{
    public function __construct(
        public UserResource $user,
        public string $access_token,
        public string $refresh_token,
    ) {}
}
