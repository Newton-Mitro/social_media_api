<?php

namespace App\Features\Auth\Authentication\UseCases\Commands\ResetPassword;

use Exception;
use DateTimeImmutable;
use App\Core\Bus\IQueryBus;
use App\Core\Bus\ICommandBus;
use App\Core\Bus\CommandHandler;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\Response;
use App\Features\Auth\User\Interfaces\UserRepositoryInterface;
use App\Features\Auth\OTP\UseCases\Queries\FindUserOtp\FindUserOTPByUserIdQuery;
use App\Features\Auth\User\UseCases\Queries\FindUserByEmail\FindUserByEmailQuery;
use App\Features\Auth\Authentication\UseCases\Commands\ResetPassword\ResetPasswordCommand;

class ResetPasswordCommandHandler extends CommandHandler
{
    public function __construct(
        protected IQueryBus $queryBus,
        protected ICommandBus $commandBus,
        protected UserRepositoryInterface $repository,
    ) {
    }

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
