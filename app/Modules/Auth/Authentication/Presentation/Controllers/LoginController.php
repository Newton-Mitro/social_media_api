<?php

namespace App\Modules\Auth\Authentication\Presentation\Controllers;

use App\Core\Controllers\Controller;
use App\Modules\Auth\Authentication\Application\UseCases\UserLoginUseCase;
use App\Modules\Auth\Authentication\Presentation\Requests\LoginRequest;
use Illuminate\Http\Response;

class LoginController extends Controller
{
    public function __construct(protected UserLoginUseCase $loginUserUseCase) {}

    public function __invoke(LoginRequest $request)
    {
        $ip = $request->ip();
        $userAgent = $request->userAgent();
        $request->path();
        $request->method();
        $request->query();

        $res = $this->loginUserUseCase->handle(
            $request->data()->email,
            $request->data()->password,
            $userAgent,
            $ip,
        );

        return response()->json([
            'data' => $res,
            'message' => 'Successfully logged in',
            'errors' => null,
        ], Response::HTTP_OK);
    }
}
