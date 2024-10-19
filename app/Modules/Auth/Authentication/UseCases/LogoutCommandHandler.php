<?php

namespace App\Features\Auth\Authentication\UseCases\Commands\Logout;

use App\Features\Auth\BlacklistedToken\UseCases\Commands\AddBlackListToken\AddTokenToBlackListCommand;
use App\Features\Auth\Device\Interfaces\DeviceRepositoryInterface;
use App\Features\Auth\Device\UseCases\Queries\FindDeviceByUserIDAndDeviceName\FindDeviceByUserIDAndDeviceNameQuery;
use App\Features\Auth\User\Interfaces\UserRepositoryInterface;

class LogoutCommandHandler
{
    public function __construct(
        protected UserRepositoryInterface $repository,
        protected DeviceRepositoryInterface $deviceRepository,
    ) {}

    public function handle(LogoutCommand $command): void
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
