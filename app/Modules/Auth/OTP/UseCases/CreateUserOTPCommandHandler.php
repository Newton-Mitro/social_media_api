<?php

namespace App\Features\Auth\OTP\UseCases\Commands\CreateUserOTP;

use App\Core\Utilities\OTPGenerator;
use Illuminate\Support\Facades\Mail;
use App\Features\Auth\OTP\BusinessModel\UserOtpModel;
use App\Features\Auth\OTP\Interfaces\UserOTPRepositoryInterface;
use App\Features\Auth\Authentication\Mail\ForgotPasswordOtpEmail;
use App\Features\Auth\OTP\UseCases\Commands\CreateUserOTP\CreateUserOTPCommand;

class CreateUserOTPCommandHandler
{
    public function __construct(
        protected UserOTPRepositoryInterface $repository,
    ) {}

    public function handle(CreateUserOTPCommand $command): ?UserOtpModel
    {
        // creating user OTP
        $otpValidTime = OTPGenerator::getValidateTime();
        $otp = OTPGenerator::generateOTP();
        $expiresAt = OTPGenerator::generateExpireTime();

        $userOtpModel = new UserOtpModel(
            id: 0,
            otp: $otp,
            userId: $command->getUserId(),
            expiresAt: $expiresAt->toDateTimeImmutable(),
            isVerified: false,
        );
        // // Persist user in database

        $returnResult = $this->repository->create($userOtpModel);
        Mail::to($command->getEmail())->send(new ForgotPasswordOtpEmail($command->getUserName(), $otp, $otpValidTime));
        return $returnResult;
    }
}
