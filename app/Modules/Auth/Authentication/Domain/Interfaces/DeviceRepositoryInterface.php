<?php

namespace App\Modules\Auth\Authentication\Domain\Interfaces;

use App\Modules\Auth\Authentication\Domain\Entities\DeviceEntity;


interface DeviceRepositoryInterface
{
    public function create(DeviceEntity $model): DeviceEntity;

    public function findDeviceByUserIdAndDeviceName(string $user_id, string $device_name): ?DeviceEntity;

    public function findDeviceWithToken(string $device_token): ?DeviceEntity;

    public function update(int $deviceId, DeviceEntity $model): DeviceEntity;

    public function logoutFromAllDevices(string $user_id): void;

    public function findUserDevices(string $user_id): array;
}
