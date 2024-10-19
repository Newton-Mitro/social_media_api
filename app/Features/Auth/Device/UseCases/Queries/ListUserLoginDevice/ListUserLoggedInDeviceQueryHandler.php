<?php

namespace App\Features\Auth\Device\UseCases\Queries\ListUserLoginDevice;

use App\Core\Bus\Query;
use App\Features\Auth\Device\Interfaces\DeviceRepositoryInterface;

class ListUserLoggedInDeviceQueryHandler extends Query
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
