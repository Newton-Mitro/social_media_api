<?php

namespace App\Modules\Auth\Authentication\UseCases;

use App\Modules\Auth\BlacklistedToken\BusinessModels\BlacklistedTokenModel;
use App\Modules\Auth\BlacklistedToken\Interfaces\BlacklistedTokenRepositoryInterface;
use App\Modules\Auth\BlacklistedToken\UseCases\Commands\AddBlackListToken\AddTokenToBlackListCommand;
use App\Modules\Auth\Device\Interfaces\DeviceRepositoryInterface;
use App\Modules\Auth\Device\UseCases\Queries\FindDeviceByUserIDAndDeviceName\FindDeviceByUserIDAndDeviceNameQuery;
use App\Modules\Auth\User\Interfaces\UserRepositoryInterface;

class LogoutCommandHandler
{
    public function __construct(
        protected UserRepositoryInterface $userRepository,
        protected DeviceRepositoryInterface $deviceRepository,
        protected BlacklistedTokenRepositoryInterface $blacklistedTokenRepository
    ) {}

    public function handle(string $userId, string $deviceName, string $token): void
    {
        $addBlackListToken = new BlacklistedTokenModel(
            id: 0,
            token: $token
        );

        $this->blacklistedTokenRepository->addTokenToBlackList($addBlackListToken);


        $device = $this->deviceRepository->findDeviceByUserIdAndDeviceName(
            $userId,
            $deviceName
        );

        if ($device) {
            $this->deviceRepository->logoutFromAllDevices($userId);
        }
    }
}
