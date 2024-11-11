<?php

namespace App\Modules\Auth\Authentication\Application\Resources;


class DeviceResource
{
    public function __construct(
        public string $id,
        public string $userId,
        public string $deviceName,
        public string $deviceIp,
        public string $deviceToken,
        public string $deviceIdentifier,
    ) {}
}
