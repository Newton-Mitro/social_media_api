<?php

namespace App\Features\Auth\Device\UseCases\Commands\CreateDevice;

use App\Core\Bus\Command;
use DateTimeImmutable;

class CreateDeviceCommand extends Command
{
    public function __construct(
        private readonly string $userId,
        private readonly string $deviceName,
        private readonly string $deviceIp,
        private readonly string $deviceToken,
        private readonly string $deviceIdentifier,
        private readonly DateTimeImmutable $createdAt,
        private readonly DateTimeImmutable $updatedAt
    ) {}

    public function getUserId(): string
    {
        return $this->userId;
    }

    public function getDeviceName(): string
    {
        return $this->deviceName;
    }

    public function getDeviceIp(): string
    {
        return $this->deviceIp;
    }

    public function getDeviceToken(): string
    {
        return $this->deviceToken;
    }

    public function getDeviceIdentifier(): string
    {
        return $this->deviceIdentifier;
    }

    public function getCreatedAt(): DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function getUpdatedAt(): DateTimeImmutable
    {
        return $this->updatedAt;
    }
}
