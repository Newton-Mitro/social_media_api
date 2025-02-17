<?php

namespace App\Modules\Auth\Infrastructure\Repositories;

use App\Modules\Auth\Domain\Entities\DeviceEntity;
use App\Modules\Auth\Domain\Interfaces\DeviceRepositoryInterface;
use App\Modules\Auth\Infrastructure\Mappers\DeviceEntityMapper;
use App\Modules\Auth\Infrastructure\Mappers\DeviceMapper;
use App\Modules\Auth\Infrastructure\Mappers\DeviceModelMapper;
use App\Modules\Auth\Infrastructure\Models\Device;
use Illuminate\Support\Collection;

class DeviceRepository implements DeviceRepositoryInterface
{
    public function findDeviceByUserIdAndDeviceName(string $user_id, string $device_name): ?DeviceEntity
    {
        $device = Device::where('user_id', $user_id)->where('device_name', $device_name)->first();
        if ($device) {
            return DeviceMapper::toEntity($device);
        }

        return null;
    }

    public function findDeviceWithToken(string $device_token): ?DeviceEntity
    {
        $device = Device::where('device_token', $device_token)->first();
        if ($device) {
            return DeviceMapper::toEntity($device);
        }

        return null;
    }

    public function save(DeviceEntity $entity): void
    {
        $user = DeviceMapper::toModel($entity);
        $user->save();
    }



    public function removeDevices(string $user_id): void
    {
        Device::where('user_id', $user_id)->delete();
    }

    public function findUserDevices(string $user_id): Collection
    {
        return Device::where('user_id', $user_id)->get();
    }
}
