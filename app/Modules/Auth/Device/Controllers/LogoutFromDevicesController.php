<?php

namespace App\Features\Auth\Device\Controllers;

use App\Core\Bus\ICommandBus;
use App\Core\Controllers\Controller;
use App\Features\Auth\Device\UseCases\Commands\LogoutFromAllDevice\LogoutFromAllDevicesCommand;
use Illuminate\Http\Response;

class LogoutFromDevicesController extends Controller
{
    public function __construct(protected ICommandBus $commandBus) {}

    public function index(int $user_id)
    {
        $this->commandBus->dispatch(new LogoutFromAllDevicesCommand($user_id));

        return response()->json(['message' => 'Logged out from all devices successfully'], Response::HTTP_OK);
    }
}
