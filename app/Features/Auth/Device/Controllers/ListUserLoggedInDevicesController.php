<?php

namespace App\Features\Auth\Device\Controllers;

use App\Core\Bus\IQueryBus;
use App\Core\Controllers\Controller;
use App\Features\Auth\Device\Resources\DeviceCollection;
use App\Features\Auth\Device\UseCases\Queries\ListUserLoginDevice\ListUserLoggedInDeviceQuery;

class ListUserLoggedInDevicesController extends Controller
{
    public function __construct(protected IQueryBus $queryBus) {}

    public function index(string $user_id)
    {
        $devices = $this->queryBus->ask(
            new ListUserLoggedInDeviceQuery($user_id)
        );

        return new DeviceCollection($devices);
    }
}
