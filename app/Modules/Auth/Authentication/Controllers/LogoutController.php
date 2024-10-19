<?php

namespace App\Features\Auth\Authentication\Controllers;

use App\Core\Bus\ICommandBus;
use App\Core\Bus\IQueryBus;
use App\Core\Controllers\Controller;
use App\Features\Auth\Authentication\UseCases\Commands\Logout\LogoutCommand;
use Illuminate\Http\Request;

class LogoutController extends Controller
{
    public function __construct(
        protected ICommandBus $commandBus,
        protected IQueryBus $queryBus,
    ) {}

    public function __invoke(Request $request)
    {
        $userId = request()->get('uid');
        $access_token = request()->bearerToken();
        $ip = $request->ip();
        $userAgent = $request->userAgent();

        $this->commandBus->dispatch(
            new LogoutCommand($userId, $access_token, $userAgent, $ip)
        );

        return response()->json([
            'data' => null,
            'message' => 'Successfully logged out',
            'errors' => null,
        ]);
    }
}
