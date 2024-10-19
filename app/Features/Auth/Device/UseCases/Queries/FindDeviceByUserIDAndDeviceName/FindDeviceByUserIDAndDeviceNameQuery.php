<?php

namespace App\Features\Auth\Device\UseCases\Queries\FindDeviceByUserIDAndDeviceName;

use App\Core\Bus\Query;

class FindDeviceByUserIDAndDeviceNameQuery extends Query
{
    public function __construct(
        private readonly string $userId,
        private readonly string $userName,
    ) {}

    public function getUserId(): string
    {
        return $this->userId;
    }

    public function getUserName(): string
    {
        return $this->userName;
    }
}
