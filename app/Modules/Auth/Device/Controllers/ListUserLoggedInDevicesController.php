<?php

namespace App\Modules\Auth\Device\Controllers;

use App\Core\Controllers\Controller;
use App\Modules\Auth\Device\Resources\DeviceCollection;
use App\Modules\Auth\Device\UseCases\Queries\ListUserLoginDevice\ListUserLoggedInDeviceQuery;

class ListUserLoggedInDevicesController extends Controller
{
    public function __construct() {}

    public function index(string $user_id)
    {
        $devices = $this->queryBus->ask(
            new ListUserLoggedInDeviceQuery($user_id)
        );

        return new DeviceCollection($devices);
    }
}
