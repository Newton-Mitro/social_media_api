<?php

namespace App\Modules\Auth\Authentication\UseCases;

use App\Modules\Auth\BlacklistedToken\UseCases\Commands\AddBlackListToken\AddTokenToBlackListCommand;
use App\Modules\Auth\Device\Interfaces\DeviceRepositoryInterface;
use App\Modules\Auth\Device\UseCases\Queries\FindDeviceByUserIDAndDeviceName\FindDeviceByUserIDAndDeviceNameQuery;
use App\Modules\Auth\User\Interfaces\UserRepositoryInterface;

class LogoutCommandHandler
{
    public function __construct(
        protected UserRepositoryInterface $repository,
        protected DeviceRepositoryInterface $deviceRepository,
    ) {}

    public function handle(): void
    {
        $this->commandBus->dispatch(
            new AddTokenToBlackListCommand(
                token: $command->getAccessToken(),
            ),
        );

        $device = $this->queryBus->ask(
            new FindDeviceByUserIDAndDeviceNameQuery($command->getUserId(), $command->getDeviceName())
        );

        if ($device) {
            // TODO:
            $this->deviceRepository->logoutFromAllDevices($command->getUserId());
        }
    }
}
