<?php

namespace App\Features\Auth\OTP\UseCases\Commands\VerifyForgotPasswordOTP;

use Exception;
use Carbon\Carbon;
use App\Core\Bus\IQueryBus;
use App\Core\Bus\ICommandBus;
use Illuminate\Http\Response;
use App\Core\Bus\CommandHandler;
use App\Features\Auth\OTP\BusinessModel\UserOtpModel;
use App\Features\Auth\OTP\UseCases\Commands\UpdateUserOTP\UpdateUserOTPCommand;
use App\Features\Auth\OTP\UseCases\Queries\FindUserOtp\FindUserOTPByUserIdQuery;
use App\Features\Auth\User\UseCases\Queries\FindUserByEmail\FindUserByEmailQuery;
use App\Features\Auth\OTP\UseCases\Commands\UpdateForgotPasswordOTPVerificationStatus\UpdateForgotPasswordOTPVerificationStatusCommand;

class VerifyForgotPasswordOTPCommandHandler extends CommandHandler
{
    public function __construct(
        protected IQueryBus $queryBus,
        protected ICommandBus $commandBus
    ) {
    }

    public function handle(VerifyForgotPasswordOTPCommand $command): ?UserOtpModel
    {
        // if user email don't exists, through exception
        // if user email exists, get OTP information by user id
        // if valid, process to next setp
        // if not valid, return validation failed exception
        $user = $this->queryBus->ask(
            new FindUserByEmailQuery($command->getEmail())
        );
        if ($user === null) {
            throw new Exception('Email is not valid', Response::HTTP_NOT_FOUND);
        } else {
            //Get user OTP
            $userOTP = $this->queryBus->ask(
                new FindUserOTPByUserIdQuery(userId: $user->getUserId())
            );
            if ($userOTP->getOtp() === $command->getOtp() && $userOTP->getExpiresAt() > Carbon::now() && $userOTP->getIsVerified() === false) {
                return $this->commandBus->dispatch(
                    new UpdateUserOTPCommand(userName: $user->getName(), userId: $user->getUserId(), email: $command->getEmail(), verificationStatus: true)
                );
            } else {
                throw new Exception('Invalid OTP', Response::HTTP_BAD_REQUEST);
            }
        }
    }
}