<?php

namespace App\Features\Auth\Authentication\UseCases\Commands\ReSendEmailVerifyingOTP;

use App\Core\Bus\CommandHandler;
use App\Core\Bus\ICommandBus;
use App\Core\Bus\IQueryBus;
use App\Features\Auth\Authentication\UseCases\Commands\SendEmailVerifyingOTP\SendEmailVerifyingOTPCommand;
use App\Features\Auth\User\Interfaces\UserRepositoryInterface;
use App\Features\Auth\User\UseCases\Queries\FindUserByEmail\FindUserByEmailQuery;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Response;

class ReSendEmailVerifyingOTPCommandHandler extends CommandHandler
{
    public function __construct(
        protected UserRepositoryInterface $repository,
        protected ICommandBus $commandBus,
        protected IQueryBus $queryBus
    ) {}

    public function handle(ReSendEmailVerifyingOTPCommand $command): void
    {
        $user = $this->queryBus->ask(
            new FindUserByEmailQuery($command->getEmail())
        );

        if (! $user) {
            throw new Exception('User not found', Response::HTTP_NOT_FOUND);
        }

        if ($user->getOtpExpiresAt() && $user->getOtpExpiresAt() > Carbon::now()) {
            throw new Exception('OTP is still valid. Please check your email.', Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $this->commandBus->dispatch(
            new SendEmailVerifyingOTPCommand(
                email: $command->getEmail(),
            ),
        );
    }
}
