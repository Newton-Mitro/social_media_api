<?php

namespace App\Modules\Auth\Authentication\UseCases;

use ErrorException;
use Illuminate\Support\Str;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Event;
use App\Modules\Auth\User\BusinessModels\UserModel;
use App\Modules\Auth\Authentication\Events\UserRegistered;
use App\Modules\Auth\User\Interfaces\UserRepositoryInterface;
use App\Modules\Auth\Authentication\UseCases\SendEmailVerifyingOTPCommandHandler;

class RegisterUserCommandHandler
{
    public function __construct(
        protected UserRepositoryInterface $repository,
        protected SendEmailVerifyingOTPCommandHandler $sendEmailVerifyingOTPCommandHandler
    ) {}

    public function handle(string $name, string $email, string $password): UserModel
    {
        // Check if user already exist
        $existingUser = $this->repository->findUserByEmail($email);

        if ($existingUser) {
            throw new ErrorException('User already exist', Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        $userModel = new UserModel(
            userId: 0,
            name: $name,
            userName: Str::slug($name, '_'),
            email: $email,
            password: $password,
        );

        // Persist user in database
        $user = $this->repository->create(
            $userModel
        );

        if ($user) {
            Event::dispatch(new UserRegistered($user));
            $this->sendEmailVerifyingOTPCommandHandler->handle($email);
        }

        return $user;
    }
}
