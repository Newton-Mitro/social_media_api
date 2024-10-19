<?php

namespace App\Features\Auth\Authentication\UseCases\Commands\Register;

use App\Features\Auth\Authentication\Events\UserRegistered;
use App\Features\Auth\Authentication\UseCases\Commands\SendEmailVerifyingOTP\SendEmailVerifyingOTPCommand;
use App\Features\Auth\User\BusinessModels\UserModel;
use App\Features\Auth\User\Interfaces\UserRepositoryInterface;
use App\Features\Auth\User\UseCases\Queries\FindUserByEmail\FindUserByEmailQuery;
use ErrorException;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Str;

class RegisterUserCommandHandler
{
    public function __construct(
        protected UserRepositoryInterface $repository,
    ) {}

    public function handle(RegisterUserCommand $command): string
    {
        // Check if user already exist
        $existingUser = $this->queryBus->ask(
            new FindUserByEmailQuery($command->getEmail())
        );

        if ($existingUser) {
            throw new ErrorException('User already exist', Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        $userModel = new UserModel(
            userId: 0,
            name: $command->getName(),
            userName: Str::slug($command->getName(), '_'),
            email: $command->getEmail(),
            password: $command->getPassword(),
        );

        // Persist user in database
        $user = $this->repository->create(
            $userModel
        );

        if ($user) {
            Event::dispatch(new UserRegistered($user));
            $this->commandBus->dispatch(
                new SendEmailVerifyingOTPCommand(
                    email: $command->getEmail(),
                ),
            );
        }

        return $user->getUserId();
    }
}
