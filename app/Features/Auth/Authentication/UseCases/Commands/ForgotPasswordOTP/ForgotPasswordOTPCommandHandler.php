<?php

namespace App\Features\Auth\Authentication\UseCases\Commands\ForgotPasswordOTP;

use Exception;
use App\Core\Bus\IQueryBus;
use App\Core\Bus\ICommandBus;
use Illuminate\Http\Response;
use App\Core\Bus\CommandHandler;
use Illuminate\Support\Facades\Mail;
use App\Features\Auth\OTP\BusinessModel\UserOtpModel;
use App\Features\Auth\Authentication\Mail\ForgotPasswordOtpEmail;
use App\Features\Auth\OTP\UseCases\Commands\CreateUserOTP\CreateUserOTPCommand;
use App\Features\Auth\OTP\UseCases\Commands\UpdateUserOTP\UpdateUserOTPCommand;
use App\Features\Auth\OTP\UseCases\Queries\FindUserOtp\FindUserOTPByUserIdQuery;
use App\Features\Auth\User\UseCases\Queries\FindUserByEmail\FindUserByEmailQuery;
use App\Features\Auth\Authentication\UseCases\Commands\ForgotPasswordOTP\ForgotPasswordOTPCommand;

class ForgotPasswordOTPCommandHandler extends CommandHandler
{
    public function __construct(
        protected IQueryBus $queryBus,
        protected ICommandBus $commandBus
    ) {
    }

    public function handle(ForgotPasswordOTPCommand $command): ?UserOtpModel
    {
        // if user email don't exists, through exception
        // if user email exists, generate otp and store otp to table and email OTP to user email
        $user = $this->queryBus->ask(
            new FindUserByEmailQuery($command->getEmail())
        );

        if ($user === null) {
            throw new Exception('Email is not valid', Response::HTTP_NOT_FOUND);
        }
        $userOTP = $this->queryBus->ask(
            new FindUserOTPByUserIdQuery(userId: $user->getUserId())
        );
        if ($userOTP === null) {
            $userOTP = $this->commandBus->dispatch(
                new CreateUserOTPCommand(userName: $user->getName(), userId: $user->getUserId(), email: $command->getEmail())
            );
        }
        //generate otp and store otp to table and emil to user email
        else {
            $userOTP = $this->commandBus->dispatch(
                new UpdateUserOTPCommand(userName: $user->getName(), userId: $user->getUserId(), email: $command->getEmail(), verificationStatus: false)
            );

        }
        return $userOTP;
    }
}