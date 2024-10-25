<?php

namespace App\Modules\Auth\Authentication\Controllers;

use App\Core\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\Response;
use App\Modules\Auth\Authentication\Requests\UserRegistrationRequest;
use App\Modules\Auth\Authentication\UseCases\RegisterUserCommandHandler;

class RegistrationController extends Controller
{
    public function __construct(protected RegisterUserCommandHandler $registerUserCommandHandler) {}

    public function __invoke(UserRegistrationRequest $request)
    {
        $ip = $request->ip();
        $userAgent = $request->userAgent();
        $request->path();
        $request->method();
        $request->query();

        $res = $this->registerUserCommandHandler->handle(
            name: $request->data()->name,
            email: $request->data()->email,
            password: Hash::make($request->data()->password),
            deviceName: $userAgent,
            deviceIP: $ip,
        );

        return response()->json([
            'data' => $res,
            'message' => 'User registered successfully.',
            'errors' => null,
        ], Response::HTTP_CREATED);
    }
}
