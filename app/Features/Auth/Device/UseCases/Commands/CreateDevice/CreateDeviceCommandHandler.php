<?php

namespace App\Features\Auth\Device\UseCases\Commands\CreateDevice;

use App\Core\Bus\CommandHandler;
use App\Features\Auth\Device\BusinessModels\DeviceModel;
use App\Features\Auth\Device\Interfaces\DeviceRepositoryInterface;
use Exception;
use Illuminate\Http\Response;

class CreateDeviceCommandHandler extends CommandHandler
{
    public function __construct(
        protected readonly DeviceRepositoryInterface $repository,
    ) {}

    public function handle(CreateDeviceCommand $command): ?DeviceModel
    {
        $deviceModel = new DeviceModel(
            deviceId: 0,
            userId: $command->getUserId(),
            deviceName: $command->getDeviceName(),
            deviceIp: $command->getDeviceIp(),
            deviceToken: $command->getDeviceToken(),
            deviceIdentifier: $command->getDeviceIdentifier(),
            createdAt: $command->getCreatedAt(),
            updatedAt: $command->getUpdatedAt(),
        );

        $device = $this->repository->create($deviceModel);

        if ($device) {
            return $device;
        }

        throw new Exception('Unable to crate device token', Response::HTTP_UNPROCESSABLE_ENTITY);
    }
}
