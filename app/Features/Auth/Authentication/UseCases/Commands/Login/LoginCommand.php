<?php

namespace App\Features\Auth\Authentication\UseCases\Commands\Login;

use App\Core\Bus\Command;

class LoginCommand extends Command
{
    public function __construct(
        private readonly string $email,
        private readonly string $password,
        private readonly string $device_name,
        private readonly string $device_ip,
    ) {}

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getPassword(): string
    {
        return $this->password;
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
