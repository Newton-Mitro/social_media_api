<?php

namespace App\Features\Auth\Device\UseCases\Queries\ListUserLoginDevice;

use App\Core\Bus\Query;

class ListUserLoggedInDeviceQuery extends Query
{
    public function __construct(
        private readonly string $user_id,
    ) {}

    public function getUserId(): string
    {
        return $this->user_id;
    }
}
