<?php

namespace App\Modules\Auth\Authentication\UseCases\Commands\ResetPassword;

use Exception;
use DateTimeImmutable;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\Response;
use App\Modules\Auth\User\Interfaces\UserRepositoryInterface;
use App\Modules\Auth\OTP\UseCases\Queries\FindUserOtp\FindUserOTPByUserIdQuery;
use App\Modules\Auth\User\UseCases\Queries\FindUserByEmail\FindUserByEmailQuery;
use App\Modules\Auth\Authentication\UseCases\Commands\ResetPassword\ResetPasswordCommand;

class ResetPasswordCommandHandler
{
    public function __construct(
        protected UserRepositoryInterface $repository,
    ) {}

    public function handle(ResetPasswordCommand $command): void
    {
        // if user email don't exists, through exception
        // if user email exists, reset password
        $user = $this->queryBus->ask(
            new FindUserByEmailQuery($command->getEmail())
        );
        if ($user === null) {
            throw new Exception('Email is not valid', Response::HTTP_NOT_FOUND);
        }
        $userOTP = $this->queryBus->ask(
            new FindUserOTPByUserIdQuery(userId: $user->getUserId())
        );
        // if token matched then reset the password
        if ($userOTP->getToken() === $command->getToken()) {
            $user->setPassword(Hash::make($command->getPassword()));
            $user->setUpdatedAt(new DateTimeImmutable);
            $this->repository->update($user->getUserId(), $user);
        } else {
            throw new Exception('Bad request', Response::HTTP_BAD_REQUEST);
        }
    }
}
