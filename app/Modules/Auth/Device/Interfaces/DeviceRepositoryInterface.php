<?php

namespace App\Modules\Auth\Device\Interfaces;

use App\Modules\Auth\Device\BusinessModels\DeviceModel;

interface DeviceRepositoryInterface
{
    public function create(DeviceModel $model): DeviceModel;

    public function findDeviceByUserIdAndDeviceName(int $user_id, string $device_name): ?DeviceModel;

    public function findDeviceWithToken(string $device_token): ?DeviceModel;

    public function update(int $deviceId, DeviceModel $model): DeviceModel;

    public function logoutFromAllDevices(int $user_id): void;

    public function findUserDevices(int $user_id): array;
}
