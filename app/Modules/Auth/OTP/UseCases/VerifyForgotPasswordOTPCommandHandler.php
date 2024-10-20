<?php

namespace App\Modules\Auth\OTP\UseCases;

use Exception;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Http\Response;
use App\Core\Utilities\OTPGenerator;
use Illuminate\Support\Facades\Mail;
use App\Modules\Auth\OTP\BusinessModel\UserOtpModel;
use App\Modules\Auth\User\Interfaces\UserRepositoryInterface;
use App\Modules\Auth\OTP\Interfaces\UserOTPRepositoryInterface;
use App\Modules\Auth\Authentication\Mail\ForgotPasswordOtpEmail;

class VerifyForgotPasswordOTPCommandHandler
{
    public function __construct(
        protected UserRepositoryInterface $userRepositoryInterface,
        protected UserOTPRepositoryInterface $userOTPRepositoryInterface
    ) {}

    public function handle(string $email, string $otp): ?UserOtpModel
    {
        // if user email don't exists, through exception
        // if user email exists, get OTP information by user id
        // if valid, process to next setp
        // if not valid, return validation failed exception
        $user = $this->userRepositoryInterface->findUserByEmail(
            $email
        );
        if ($user === null) {
            throw new Exception('Email is not valid', Response::HTTP_NOT_FOUND);
        } else {
            //Get user OTP
            $userOTP = $this->userOTPRepositoryInterface->findUserOTPByUserId(
                $user->getUserId()
            );
            if ($userOTP->getOtp() === $otp && $userOTP->getExpiresAt() > Carbon::now() && $userOTP->getIsVerified() === false) {
                // creating user OTP
                $otpValidTime = OTPGenerator::getValidateTime();
                $otp = OTPGenerator::generateOTP();
                $expiresAt = OTPGenerator::generateExpireTime();
                $otpToken = Str::random();
                $userOTP = $this->userOTPRepositoryInterface->findUserOTPByUserId(
                    $user->getUserId()
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
                $returnResult = $this->userOTPRepositoryInterface->update($userOTP);
                if ($command->getVerificationStatus() === false) {
                    Mail::to($email)->send(new ForgotPasswordOtpEmail($user->getName(), $otp, $otpValidTime));
                }
                return $returnResult;
            } else {
                throw new Exception('Invalid OTP', Response::HTTP_BAD_REQUEST);
            }
        }
    }
}
