<?php

namespace App\Features\Auth\Device\UseCases\Commands\UpdateDevice;

use App\Features\Auth\Device\BusinessModels\DeviceModel;
use App\Features\Auth\Device\Interfaces\DeviceRepositoryInterface;
use Exception;
use Illuminate\Http\Response;

class UpdateDeviceCommandHandler
{
    public function __construct(
        protected readonly DeviceRepositoryInterface $repository,
    ) {}

    public function handle(UpdateDeviceCommand $command): ?DeviceModel
    {
        $deviceModel = new DeviceModel(
            deviceId: $command->getDeviceId(),
            userId: $command->getUserId(),
            deviceName: $command->getDeviceName(),
            deviceIp: $command->getDeviceIp(),
            deviceToken: $command->getDeviceToken(),
            deviceIdentifier: $command->getDeviceIdentifier(),
            createdAt: $command->getCreatedAt(),
            updatedAt: $command->getUpdatedAt(),
        );

        $device = $this->repository->update($command->getDeviceId(), $deviceModel);

        if ($device) {
            return $device;
        }

        throw new Exception('Unable to update device token', Response::HTTP_UNPROCESSABLE_ENTITY);
    }
}
