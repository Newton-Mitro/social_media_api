<?php

namespace App\Modules\Auth\Authentication\Application\UseCases;

use App\Core\Utilities\OTPGenerator;
use App\Modules\Auth\Authentication\Application\Mail\ForgotPasswordOtpEmail;
use App\Modules\Auth\Authentication\Domain\Entities\UserOtpModel;
use App\Modules\Auth\Authentication\Domain\Interfaces\UserOTPRepositoryInterface;
use App\Modules\Auth\Authentication\Domain\Interfaces\UserRepositoryInterface;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;


class ForgotPasswordOTPCommandHandler
{
    public function __construct(
        protected readonly UserRepositoryInterface $userRepository,
        protected readonly UserOTPRepositoryInterface $otpRepository,
    ) {}

    public function handle(string $email): ?UserOtpModel
    {
        // if user email don't exists, through exception
        // if user email exists, generate otp and store otp to table and email OTP to user email
        $user = $this->userRepository->findUserByEmail(
            $email
        );

        if ($user === null) {
            throw new Exception('Email is not valid', Response::HTTP_NOT_FOUND);
        }

        $userOTP = $this->otpRepository->findUserOTPByUserId(
            $user->getUserId()
        );

        if ($userOTP === null) {
            // creating user OTP
            $otpValidTime = OTPGenerator::getValidateTime();
            $otp = OTPGenerator::generateOTP();
            $expiresAt = OTPGenerator::generateExpireTime();

            $userOtpModel = new UserOtpModel(
                id: 0,
                otp: $otp,
                userId: $user->getUserId(),
                expiresAt: $expiresAt->toDateTimeImmutable(),
                isVerified: true,
            );
            // Persist user in database
            $returnResult = $this->otpRepository->create($userOtpModel);
            Mail::to($user->getEmail())->send(new ForgotPasswordOtpEmail($user->getUserName(), $otp, $otpValidTime));
        }
        //generate otp and store otp to table and emil to user email
        else {
            // creating user OTP
            $otpValidTime = OTPGenerator::getValidateTime();
            $otp = OTPGenerator::generateOTP();
            $expiresAt = OTPGenerator::generateExpireTime();
            $otpToken = Str::random();
            $userOTP = $this->otpRepository->findUserOTPByUserId(
                $user->getUserId()
            );
            $userOTP->setId($userOTP->getId());
            $userOTP->setUserId($userOTP->getUserId());
            $userOTP->setIsVerified(true);
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
            $returnResult = $this->otpRepository->update($userOTP);
            if ($command->getVerificationStatus() === false) {
                Mail::to($email)->send(new ForgotPasswordOtpEmail($command->getUserName(), $otp, $otpValidTime));
            }
        }
        return $returnResult;
    }
}
