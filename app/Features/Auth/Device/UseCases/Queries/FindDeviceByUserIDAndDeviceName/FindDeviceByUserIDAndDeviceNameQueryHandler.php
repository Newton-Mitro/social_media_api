<?php

namespace App\Features\Auth\Device\UseCases\Queries\FindDeviceByUserIDAndDeviceName;

use App\Core\Bus\Query;
use App\Features\Auth\Device\BusinessModels\DeviceModel;
use App\Features\Auth\Device\Interfaces\DeviceRepositoryInterface;

class FindDeviceByUserIDAndDeviceNameQueryHandler extends Query
{
    public function __construct(
        protected readonly DeviceRepositoryInterface $repository,
    ) {}

    public function handle(FindDeviceByUserIDAndDeviceNameQuery $query): ?DeviceModel
    {
        return $this->repository->findDeviceByUserIdAndDeviceName(
            $query->getUserId(),
            $query->getUserName()
        );
    }
}
