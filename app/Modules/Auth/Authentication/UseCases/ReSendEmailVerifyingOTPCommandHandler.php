<?php

namespace App\Modules\Auth\Authentication\UseCases\Commands\ReSendEmailVerifyingOTP;

use App\Modules\Auth\Authentication\UseCases\Commands\SendEmailVerifyingOTP\SendEmailVerifyingOTPCommand;
use App\Modules\Auth\User\Interfaces\UserRepositoryInterface;
use App\Modules\Auth\User\UseCases\Queries\FindUserByEmail\FindUserByEmailQuery;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Response;

class ReSendEmailVerifyingOTPCommandHandler
{
    public function __construct(
        protected UserRepositoryInterface $repository,
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
