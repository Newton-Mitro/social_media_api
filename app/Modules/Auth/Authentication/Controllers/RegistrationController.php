<?php

namespace App\Features\Auth\Authentication\Controllers;

use App\Core\Bus\ICommandBus;
use App\Core\Bus\IQueryBus;
use App\Core\Controllers\Controller;
use App\Features\Auth\Authentication\Requests\UserRegistrationRequest;
use App\Features\Auth\Authentication\UseCases\Commands\Register\RegisterUserCommand;
use App\Features\Auth\User\Mappers\UserMapper;
use App\Features\Auth\User\UseCases\Queries\FindUser\FindUserQuery;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\Response;

class RegistrationController extends Controller
{
    public function __construct(
        protected ICommandBus $commandBus,
        protected IQueryBus $queryBus,
    ) {}

    public function __invoke(UserRegistrationRequest $request)
    {
        $userId = $this->commandBus->dispatch(
            new RegisterUserCommand(
                name: $request->data()->name,
                email: $request->data()->email,
                password: Hash::make($request->data()->password),
            ),
        );

        $user = $this->queryBus->ask(
            new FindUserQuery($userId)
        );

        return response()->json([
            'data' => UserMapper::toUserResource($user),
            'message' => 'User registered successfully.',
            'errors' => null,
        ], Response::HTTP_CREATED);
    }
}
