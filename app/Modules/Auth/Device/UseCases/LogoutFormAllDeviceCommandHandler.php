<?php

namespace App\Modules\Auth\Device\UseCases\Commands\LogoutFromAllDevice;

use App\Modules\Auth\Device\Interfaces\DeviceRepositoryInterface;

class LogoutFormAllDeviceCommandHandler
{
    public function __construct(
        protected readonly DeviceRepositoryInterface $repository,
    ) {}

    public function handle(LogoutFromAllDevicesCommand $command)
    {
        $this->repository->logoutFromAllDevices($command->getUserId());
    }
}
