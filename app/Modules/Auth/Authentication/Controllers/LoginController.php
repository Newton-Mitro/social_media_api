<?php

namespace App\Features\Auth\Authentication\Controllers;

use App\Core\Bus\ICommandBus;
use App\Core\Controllers\Controller;
use App\Features\Auth\Authentication\Requests\LoginRequest;
use App\Features\Auth\Authentication\UseCases\Commands\Login\LoginCommand;

class LoginController extends Controller
{
    public function __construct(
        protected ICommandBus $commandBus,
    ) {}

    public function __invoke(LoginRequest $request)
    {
        $ip = $request->ip();
        $userAgent = $request->userAgent();
        $request->path();
        $request->method();
        $request->query();

        $res = $this->commandBus->dispatch(
            new LoginCommand(
                email: $request->data()->email,
                password: $request->data()->password,
                device_name: $userAgent,
                device_ip: $ip,
            ),
        );
// dd($res);
        return response()->json([
            'data' => $res,
            'message' => $res['user']->email_verified_at ? 'Successfully logged in' : 'Your email address is not verified.',
            'errors' => null,
        ]);
    }
}
