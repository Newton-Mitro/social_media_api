<?php

namespace App\Modules\Auth\Authentication\Application\UseCases;

use App\Modules\Auth\Authentication\Domain\Entities\BlacklistedTokenModel;
use App\Modules\Auth\Authentication\Domain\Interfaces\BlacklistedTokenRepositoryInterface;
use App\Modules\Auth\Authentication\Domain\Interfaces\DeviceRepositoryInterface;
use App\Modules\Auth\Authentication\Domain\Interfaces\UserRepositoryInterface;


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
