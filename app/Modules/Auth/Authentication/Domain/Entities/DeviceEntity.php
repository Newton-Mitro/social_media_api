<?php

namespace App\Modules\Auth\Authentication\Domain\Entities;

use DateTimeImmutable;

class DeviceEntity
{
    public function __construct(
        private int $id,
        private string $userId,
        private string $deviceName,
        private string $deviceIp,
        private string $deviceToken,
        private string $deviceIdentifier,
        private DateTimeImmutable $createdAt = new DateTimeImmutable,
        private DateTimeImmutable $updatedAt = new DateTimeImmutable
    ) {}

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getUserId(): string
    {
        return $this->userId;
    }

    public function setUserId(string $userId): void
    {
        $this->userId = $userId;
    }

    public function getDeviceName(): string
    {
        return $this->deviceName;
    }

    public function setDeviceName(string $deviceName): void
    {
        $this->deviceName = $deviceName;
    }

    public function getDeviceIp(): string
    {
        return $this->deviceIp;
    }

    public function setDeviceIp(string $deviceIp): void
    {
        $this->deviceIp = $deviceIp;
    }

    public function getDeviceToken(): string
    {
        return $this->deviceToken;
    }

    public function setDeviceToken(string $deviceToken): void
    {
        $this->deviceToken = $deviceToken;
    }

    public function getDeviceIdentifier(): string
    {
        return $this->deviceIdentifier;
    }

    public function setDeviceIdentifier(string $deviceIdentifier): void
    {
        $this->deviceIdentifier = $deviceIdentifier;
    }

    public function getCreatedAt(): DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(DateTimeImmutable $createdAt): void
    {
        $this->createdAt = $createdAt;
    }

    public function getUpdatedAt(): DateTimeImmutable
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(DateTimeImmutable $updatedAt): void
    {
        $this->updatedAt = $updatedAt;
    }
}
