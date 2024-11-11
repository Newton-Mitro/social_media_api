<?php

namespace App\Modules\Auth\Authentication\Infrastructure\Mappers;

use App\Modules\Auth\Authentication\Domain\Entities\DeviceEntity;
use App\Modules\Auth\Authentication\Infrastructure\Models\Device;
use DateTimeImmutable;

class DeviceEntityMapper
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
}
