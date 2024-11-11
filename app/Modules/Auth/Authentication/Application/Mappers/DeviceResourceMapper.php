<?php

namespace App\Modules\Auth\Authentication\Application\Mappers;

use App\Modules\Auth\Authentication\Application\Resources\DeviceResource;
use App\Modules\Auth\Authentication\Domain\Entities\DeviceEntity;

class DeviceResourceMapper
{
    public static function toResource(DeviceEntity $entity): DeviceResource
    {
        return new DeviceResource(
            id: $entity->getId(),
            userId: $entity->getUserId(),
            deviceName: $entity->getDeviceName(),
            deviceIp: $entity->getDeviceIp(),
            deviceToken: $entity->getDeviceToken(),
            deviceIdentifier: $entity->getDeviceIdentifier()
        );
    }
}
