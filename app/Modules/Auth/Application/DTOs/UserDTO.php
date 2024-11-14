<?php

namespace App\Modules\Auth\Application\DTOs;


class UserDTO
{
    public function __construct(
        public string $id,
        public string $name,
        public string $username,
        public string $email,
        public bool $account_verified,
        public ?string $profile_picture,
        public ?string $cover_photo,
    ) {}
}