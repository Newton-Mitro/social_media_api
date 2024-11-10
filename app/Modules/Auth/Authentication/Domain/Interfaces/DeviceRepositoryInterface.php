<?php

namespace App\Modules\Auth\Authentication\Domain\Interfaces;

use App\Modules\Auth\Authentication\Domain\Entities\DeviceModel;


interface DeviceRepositoryInterface
{
    public function create(DeviceModel $model): DeviceModel;

    public function findDeviceByUserIdAndDeviceName(string $user_id, string $device_name): ?DeviceModel;

    public function findDeviceWithToken(string $device_token): ?DeviceModel;

    public function update(int $deviceId, DeviceModel $model): DeviceModel;

    public function logoutFromAllDevices(string $user_id): void;

    public function findUserDevices(string $user_id): array;
}
