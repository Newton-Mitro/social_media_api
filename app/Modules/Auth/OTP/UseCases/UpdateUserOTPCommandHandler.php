<?php

namespace App\Features\Auth\OTP\UseCases\Commands\UpdateUserOTP;

use Carbon\Carbon;
use Illuminate\Support\Str;
use App\Core\Utilities\OTPGenerator;
use Illuminate\Support\Facades\Mail;
use App\Features\Auth\OTP\BusinessModel\UserOtpModel;
use App\Features\Auth\OTP\Interfaces\UserOTPRepositoryInterface;
use App\Features\Auth\Authentication\Mail\ForgotPasswordOtpEmail;
use App\Features\Auth\OTP\UseCases\Queries\FindUserOtp\FindUserOTPByUserIdQuery;

class UpdateUserOTPCommandHandler
{
    public function __construct(
        protected UserOTPRepositoryInterface $repository
    ) {}

    public function handle(UpdateUserOTPCommand $command): ?UserOtpModel
    {
        // creating user OTP
        $otpValidTime = OTPGenerator::getValidateTime();
        $otp = OTPGenerator::generateOTP();
        $expiresAt = OTPGenerator::generateExpireTime();
        $otpToken = Str::random();
        $userOTP = $this->queryBus->ask(
            new FindUserOTPByUserIdQuery(userId: $command->getUserId())
        );
        $userOTP->setId($userOTP->getId());
        $userOTP->setUserId($userOTP->getUserId());
        $userOTP->setIsVerified($command->getVerificationStatus());
        // verification status changed then no data will be changed
        if ($command->getVerificationStatus() === true) {
            $userOTP->setOtp($userOTP->getOtp());
            $userOTP->setExpiresAt($userOTP->getExpiresAt());
            $userOTP->setToken($otpToken);
        }
        // if verification status, no changed then new otp & otp expiration will be added
        else {
            $userOTP->setOtp($otp);
            $userOTP->setExpiresAt($expiresAt->toDateTimeImmutable());
            $userOTP->setToken(null);
        }
        $userOTP->setCreatedAt($userOTP->getCreatedAt());
        $userOTP->setUpdatedAt(Carbon::now()->toDateTimeImmutable());
        $returnResult = $this->repository->update($userOTP);
        if ($command->getVerificationStatus() === false) {
            Mail::to($command->getEmail())->send(new ForgotPasswordOtpEmail($command->getUserName(), $otp, $otpValidTime));
        }
        return $returnResult;
    }
}
