<?php

namespace App\Features\Auth\Device\UseCases\Queries\FindDeviceWithToken;

use App\Core\Bus\Query;
use App\Features\Auth\Device\BusinessModels\DeviceModel;
use App\Features\Auth\Device\Interfaces\DeviceRepositoryInterface;
use Exception;
use Illuminate\Http\Response;

class FindDeviceWithTokenQueryHandler extends Query
{
    public function __construct(
        protected readonly DeviceRepositoryInterface $repository,
    ) {}

    public function handle(FindDeviceWithTokenQuery $Query): ?DeviceModel
    {
        $device = $this->repository->findDeviceWithToken($Query->getDeviceToken());

        if ($device instanceof \App\Features\Auth\Device\BusinessModels\DeviceModel) {
            return $device;
        }

        throw new Exception('Device not found', Response::HTTP_NOT_FOUND);
    }
}
