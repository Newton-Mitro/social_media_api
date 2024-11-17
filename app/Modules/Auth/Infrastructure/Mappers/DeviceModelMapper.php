<?php

namespace App\Modules\Auth\Infrastructure\Mappers;

use App\Modules\Auth\Domain\Entities\DeviceEntity;
use App\Modules\Auth\Infrastructure\Models\Device;

class DeviceModelMapper
{
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
