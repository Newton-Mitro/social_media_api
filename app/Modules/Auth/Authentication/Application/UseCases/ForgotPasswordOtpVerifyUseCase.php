<?php

namespace App\Modules\Auth\Authentication\Application\UseCases;

use App\Core\Utilities\OTPGenerator;
use App\Modules\Auth\Authentication\Application\Resources\UserOtpResource;
use App\Modules\Auth\Authentication\Domain\Entities\UserOtpEntity;
use App\Modules\Auth\Authentication\Domain\Interfaces\UserOTPRepositoryInterface;
use App\Modules\Auth\Authentication\Domain\Interfaces\UserRepositoryInterface;
use App\Modules\Auth\Authentication\Infrastructure\Mail\ForgotPasswordOtpEmail;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class ForgotPasswordOtpVerifyUseCase
{
    public function __construct(
        protected UserRepositoryInterface $userRepositoryInterface,
        protected UserOTPRepositoryInterface $userOTPRepositoryInterface
    ) {}

    // TODO : fix me
    public function handle(string $email, string $otp): UserOtpResource
    {
        $user = $this->userRepositoryInterface->findByEmail(
            $email
        );
        if ($user === null) {
            throw new Exception('Email is not valid', Response::HTTP_NOT_FOUND);
        } else {
            //Get user OTP
            $userOTP = $this->userOTPRepositoryInterface->findUserOTPByUserId(
                $user->getId()
            );
            if ($userOTP->getOtp() === $otp && $userOTP->getExpiresAt() > Carbon::now() && $userOTP->getIsVerified() === false) {
                // creating user OTP
                $otpValidTime = OTPGenerator::getValidateTime();
                $otp = OTPGenerator::generateOTP();
                $expiresAt = OTPGenerator::generateExpireTime();
                $otpToken = Str::random();
                $userOTP = $this->userOTPRepositoryInterface->findUserOTPByUserId(
                    $user->getId()
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
