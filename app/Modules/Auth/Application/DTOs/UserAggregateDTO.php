<?php

namespace App\Modules\Auth\Application\DTOs;

use App\Modules\Auth\Application\DTOs\ProfileDTO;


class UserAggregateDTO
{
    public function __construct(
        public string $id,
        public string $name,
        public string $email,
        public bool $account_verified,
        public ProfileDTO $profile
    ) {}
}
