<?php

namespace App\Modules\Auth\User\Resources;


class UserResource
{
    public function __construct(
        public string $user_id,
        public string $name,
        public string $user_name,
        public string $email,
        public ?string $profile_picture,
        public ?string $cover_photo,
        public ?string $email_verified_at,

    ) {}
}
