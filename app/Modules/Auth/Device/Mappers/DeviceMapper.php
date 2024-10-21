<?php

namespace App\Modules\Auth\Device\Mappers;

use App\Modules\Auth\Device\BusinessModels\DeviceModel;
use App\Modules\Auth\Device\Models\Device;
use Carbon\Carbon;

class DeviceMapper
{
    public static function toBusinessModel(Device $device): DeviceModel
    {
        return new DeviceModel(
            $device->id,
            $device->user_id,
            $device->device_name,
            $device->device_ip,
            $device->device_token,
            $device->device_identifier,
            $device->created_at ? Carbon::parse($device->created_at)->toDateTimeImmutable() : null,
            $device->updated_at ? Carbon::parse($device->updated_at)->toDateTimeImmutable() : null
        );
    }

    public static function toEloquentModel(DeviceModel $deviceModel): Device
    {
        return new Device([
            'device_id' => $deviceModel->getDeviceId(),
            'user_id' => $deviceModel->getUserId(),
            'device_name' => $deviceModel->getDeviceName(),
            'device_ip' => $deviceModel->getDeviceIp(),
            'device_identifier' => $deviceModel->getDeviceIdentifier(),
            'device_token' => $deviceModel->getDeviceToken(),
            'created_at' => $deviceModel->getCreatedAt() ? Carbon::instance($deviceModel->getCreatedAt()) : null,
            'updated_at' => $deviceModel->getUpdatedAt() ? Carbon::instance($deviceModel->getUpdatedAt()) : null,
        ]);
    }
}
