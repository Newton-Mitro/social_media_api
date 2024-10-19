<?php

namespace App\Modules\Auth\Authentication\UseCases\Commands\ForgotPasswordOTP;

use Exception;
use Illuminate\Http\Response;
use App\Modules\Auth\OTP\BusinessModel\UserOtpModel;
use App\Modules\Auth\OTP\UseCases\Commands\CreateUserOTP\CreateUserOTPCommand;
use App\Modules\Auth\OTP\UseCases\Commands\UpdateUserOTP\UpdateUserOTPCommand;
use App\Modules\Auth\OTP\UseCases\Queries\FindUserOtp\FindUserOTPByUserIdQuery;
use App\Modules\Auth\User\UseCases\Queries\FindUserByEmail\FindUserByEmailQuery;
use App\Modules\Auth\Authentication\UseCases\Commands\ForgotPasswordOTP\ForgotPasswordOTPCommand;

class ForgotPasswordOTPCommandHandler
{
    public function __construct() {}

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
