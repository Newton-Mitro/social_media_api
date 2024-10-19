<?php

namespace App\Features\Auth\Authentication\UseCases\Commands\RefreshToken;

use App\Core\Bus\Command;

class RefreshTokenCommand extends Command
{
    public function __construct(
        private readonly int $user_id,
        private readonly string $device_name,
        private readonly string $device_ip,
    ) {}

    public function getUserId(): int
    {
        return $this->user_id;
    }

    public function getDeviceName(): string
    {
        return $this->device_name;
    }

    public function getDeviceIp(): string
    {
        return $this->device_ip;
    }
}
