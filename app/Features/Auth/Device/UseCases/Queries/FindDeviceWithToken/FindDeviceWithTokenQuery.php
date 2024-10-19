<?php

namespace App\Features\Auth\Device\UseCases\Queries\FindDeviceWithToken;

use App\Core\Bus\Query;

class FindDeviceWithTokenQuery extends Query
{
    public function __construct(
        private readonly string $device_token,
    ) {}

    public function getDeviceToken(): string
    {
        return $this->device_token;
    }
}
