<?php

namespace App\Modules\Auth\Presentation\Controllers;

use App\Core\Controllers\Controller;
use App\Modules\Auth\Application\UseCases\RegisterUserUseCase;
use App\Modules\Auth\Presentation\Requests\UserRegistrationRequest;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\Response;

class RegistrationController extends Controller
{
    public function __construct(protected RegisterUserUseCase $registerUserUseCase) {}

    public function __invoke(UserRegistrationRequest $request)
    {
        $ip = $request->ip();
        $userAgent = $request->userAgent();
        $request->path();
        $request->method();
        $request->query();

        $res = $this->registerUserUseCase->handle(
            name: $request->input('name'),
            email: $request->input('email'),
            password: Hash::make($request->input('password')),
            deviceName: $userAgent,
            deviceIP: $ip,
        );

        return response()->json([
            'data' => $res,
            'message' => 'User registered successfully.',
            'error' => null,
            'errors' => null,
        ], Response::HTTP_CREATED);
    }
}
