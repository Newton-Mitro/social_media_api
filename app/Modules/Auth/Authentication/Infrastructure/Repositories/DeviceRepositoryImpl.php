<?php

namespace App\Modules\Auth\Authentication\Infrastructure\Repositories;

use App\Modules\Auth\Authentication\Domain\Entities\DeviceEntity;
use App\Modules\Auth\Authentication\Domain\Interfaces\DeviceRepositoryInterface;
use App\Modules\Auth\Authentication\Infrastructure\Mappers\DeviceEntityMapper;
use App\Modules\Auth\Authentication\Infrastructure\Mappers\DeviceModelMapper;
use App\Modules\Auth\Authentication\Infrastructure\Models\Device;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class DeviceRepositoryImpl implements DeviceRepositoryInterface
{
    public function findDeviceByUserIdAndDeviceName(string $user_id, string $device_name): ?DeviceEntity
    {
        $device = Device::where('user_id', $user_id)->where('device_name', $device_name)->first();
        if ($device) {
            return DeviceEntityMapper::toEntity($device);
        }

        return null;
    }

    public function findDeviceWithToken(string $device_token): ?DeviceEntity
    {
        $device = Device::where('device_token', $device_token)->first();
        if ($device) {
            return DeviceEntityMapper::toEntity($device);
        }

        return null;
    }

    public function save(DeviceEntity $entity): void
    {
        DB::transaction(function () use ($entity) {
            $user = DeviceModelMapper::toModel($entity);
            $user->save();
        });
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
