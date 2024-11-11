<?php

namespace App\Modules\Auth\Authentication\Domain\Interfaces;

use App\Modules\Auth\Authentication\Domain\Entities\DeviceEntity;
use Illuminate\Support\Collection;

interface DeviceRepositoryInterface
{
    public function save(DeviceEntity $model): void;
    public function findDeviceByUserIdAndDeviceName(string $user_id, string $device_name): ?DeviceEntity;
    public function findDeviceWithToken(string $device_token): ?DeviceEntity;
    public function removeDevices(string $user_id): void;
    // public function removeDevice(string $user_id): void;
    public function findUserDevices(string $user_id): Collection;
}
