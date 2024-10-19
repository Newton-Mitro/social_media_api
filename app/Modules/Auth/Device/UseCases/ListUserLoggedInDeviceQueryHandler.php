<?php

namespace App\Modules\Auth\Device\UseCases\Queries\ListUserLoginDevice;

use App\Modules\Auth\Device\Interfaces\DeviceRepositoryInterface;

class ListUserLoggedInDeviceQueryHandler
{
    public function __construct(
        protected readonly DeviceRepositoryInterface $repository,
    ) {}

    public function handle(ListUserLoggedInDeviceQuery $query): array
    {
        return $this->repository->findUserDevices(
            $query->getUserId(),
        );
    }
}
