<?php

namespace App\Features\Auth\Authentication\UseCases\Commands\Logout;

use App\Core\Bus\Command;

class LogoutCommand extends Command
{
    public function __construct(
        private readonly string $user_id,
        private readonly string $access_token,
        private readonly string $device_name,
        private readonly string $device_ip,
    ) {}

    public function getUserId(): string
    {
        return $this->user_id;
    }

    public function getAccessToken(): string
    {
        return $this->access_token;
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
