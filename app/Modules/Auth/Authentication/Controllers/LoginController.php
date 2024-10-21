<?php

namespace App\Modules\Auth\Authentication\Controllers;

use App\Core\Controllers\Controller;
use App\Modules\Auth\Authentication\Requests\LoginRequest;
use App\Modules\Auth\Authentication\UseCases\LoginCommandHandler;

class LoginController extends Controller
{
    public function __construct(protected LoginCommandHandler $loginCommandHandler) {}

    public function __invoke(LoginRequest $request)
    {
        $ip = $request->ip();
        $userAgent = $request->userAgent();
        $request->path();
        $request->method();
        $request->query();

        $res = $this->loginCommandHandler->handle(
            $request->data()->email,
            $request->data()->password,
            $userAgent,
            $ip,
        );

        return response()->json([
            'data' => $res,
            'message' => $res['user']->email_verified_at ? 'Successfully logged in' : 'Your email address is not verified.',
            'errors' => null,
        ]);
    }
}
