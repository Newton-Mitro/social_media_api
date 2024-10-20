<?php

namespace App\Modules\Auth\Authentication\Controllers;

use App\Core\Controllers\Controller;
use App\Modules\Auth\Authentication\Requests\UserRegistrationRequest;
use App\Modules\Auth\Authentication\UseCases\Commands\Register\RegisterUserCommandHandler;
use App\Modules\Auth\User\Mappers\UserMapper;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\Response;

class RegistrationController extends Controller
{
    public function __construct(protected RegisterUserCommandHandler $registerUserCommandHandler) {}

    public function __invoke(UserRegistrationRequest $request)
    {
        $user = $this->registerUserCommandHandler->handle(
            name: $request->data()->name,
            email: $request->data()->email,
            password: Hash::make($request->data()->password),
        );

        return response()->json([
            'data' => UserMapper::toUserResource($user),
            'message' => 'User registered successfully.',
            'errors' => null,
        ], Response::HTTP_CREATED);
    }
}
