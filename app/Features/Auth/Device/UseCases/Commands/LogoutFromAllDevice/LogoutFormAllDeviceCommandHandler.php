<?php

namespace App\Features\Auth\Device\UseCases\Commands\LogoutFromAllDevice;

use App\Core\Bus\CommandHandler;
use App\Features\Auth\Device\Interfaces\DeviceRepositoryInterface;

class LogoutFormAllDeviceCommandHandler extends CommandHandler
{
    public function __construct(
        protected readonly DeviceRepositoryInterface $repository,
    ) {}

    public function handle(LogoutFromAllDevicesCommand $command)
    {
        $this->repository->logoutFromAllDevices($command->getUserId());
    }
}
