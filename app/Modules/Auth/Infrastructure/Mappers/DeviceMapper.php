<?php

namespace App\Modules\Auth\Infrastructure\Mappers;

use App\Modules\Auth\Domain\Entities\DeviceEntity;
use App\Modules\Auth\Infrastructure\Models\Device;
use DateTimeImmutable;

class DeviceMapper
{
    public static function toEntity(Device $model): DeviceEntity
    {
        return new DeviceEntity(
            id: $model->id,
            userId: $model->user_id,
            deviceName: $model->device_name,
            deviceIp: $model->device_ip,
            deviceToken: $model->device_token,
            deviceIdentifier: $model->device_identifier,
            createdAt: new DateTimeImmutable($model->created_at),
            updatedAt: new DateTimeImmutable($model->updated_at)
        );
    }

    public static function toModel(DeviceEntity $entity): Device
    {
        $model = Device::find($entity->getId()) ?? new Device();
        $model->id = $entity->getId();
        $model->user_id = $entity->getUserId();
        $model->device_name = $entity->getDeviceName();
        $model->device_ip = $entity->getDeviceIp();
        $model->device_token = $entity->getDeviceToken();
        $model->device_identifier = $entity->getDeviceIdentifier();
        $model->created_at = $entity->getCreatedAt();
        $model->updated_at = $entity->getUpdatedAt();

        return $model;
    }
}
