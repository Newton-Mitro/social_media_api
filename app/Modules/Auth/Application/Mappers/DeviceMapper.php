<?php

namespace App\Modules\Auth\Application\Mappers;

use App\Modules\Auth\Application\DTOs\DeviceDTO;
use App\Modules\Auth\Domain\Entities\DeviceEntity;

class DeviceMapper
{
    public static function toDTO(DeviceEntity $entity): DeviceDTO
    {
        return new DeviceDTO(
            id: $entity->getId(),
            userId: $entity->getUserId(),
            deviceName: $entity->getDeviceName(),
            deviceIp: $entity->getDeviceIp(),
            deviceToken: $entity->getDeviceToken(),
            deviceIdentifier: $entity->getDeviceIdentifier()
        );
    }
}
