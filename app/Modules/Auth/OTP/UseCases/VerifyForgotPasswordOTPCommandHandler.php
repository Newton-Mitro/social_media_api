<?php

namespace App\Modules\Auth\OTP\UseCases\Commands\VerifyForgotPasswordOTP;

use Exception;
use Carbon\Carbon;
use Illuminate\Http\Response;
use App\Modules\Auth\OTP\BusinessModel\UserOtpModel;
use App\Modules\Auth\OTP\UseCases\Commands\UpdateUserOTP\UpdateUserOTPCommand;
use App\Modules\Auth\OTP\UseCases\Queries\FindUserOtp\FindUserOTPByUserIdQuery;
use App\Modules\Auth\User\UseCases\Queries\FindUserByEmail\FindUserByEmailQuery;

class VerifyForgotPasswordOTPCommandHandler
{
    public function __construct() {}

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
