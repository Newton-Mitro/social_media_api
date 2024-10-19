<?php

namespace App\Modules\Auth\Device\UseCases\Queries\FindDeviceByUserIDAndDeviceName;

use App\Modules\Auth\Device\BusinessModels\DeviceModel;
use App\Modules\Auth\Device\Interfaces\DeviceRepositoryInterface;

class FindDeviceByUserIDAndDeviceNameQueryHandler
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
