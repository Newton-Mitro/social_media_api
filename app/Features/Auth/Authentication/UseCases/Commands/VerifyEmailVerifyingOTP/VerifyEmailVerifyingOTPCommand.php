<?php

namespace App\Features\Auth\Authentication\UseCases\Commands\VerifyEmailVerifyingOTP;

use App\Core\Bus\Command;

class VerifyEmailVerifyingOTPCommand extends Command
{
    public function __construct(
        private readonly string $device_name,
        private readonly string $device_ip,
        private readonly string $email,
        private readonly string $otp
    ) {}

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getOtp(): string
    {
        return $this->otp;
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
