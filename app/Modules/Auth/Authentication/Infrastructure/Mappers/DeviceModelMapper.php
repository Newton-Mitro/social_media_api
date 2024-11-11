<?php

namespace App\Modules\Auth\Authentication\Infrastructure\Mappers;

use App\Modules\Auth\Authentication\Domain\Entities\DeviceEntity;
use App\Modules\Auth\Authentication\Infrastructure\Models\Device;

class DeviceModelMapper
{
    public static function toModel(DeviceEntity $entity): Device
    {
        $user = Device::find($entity->getId()) ?? new Device();
        $user->user_id = $entity->getUserId();
        $user->device_name = $entity->getDeviceName();
        $user->device_ip = $entity->getDeviceIp();
        $user->device_token = $entity->getDeviceToken();
        $user->device_identifier = $entity->getDeviceIdentifier();
        $user->created_at = $entity->getCreatedAt();
        $user->updated_at = $entity->getUpdatedAt();

        return $user;
    }
}
