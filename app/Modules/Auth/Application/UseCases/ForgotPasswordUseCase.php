<?php

namespace App\Modules\Auth\Application\UseCases;

use App\Core\Utilities\OTPGenerator;
use App\Modules\Auth\Application\DTOs\UserOtpDTO;
use App\Modules\Auth\Application\Mappers\UserOtpDTOMapper;
use App\Modules\Auth\Domain\Entities\UserOtpEntity;
use App\Modules\Auth\Domain\Interfaces\UserOTPRepositoryInterface;
use App\Modules\Auth\Domain\Interfaces\UserRepositoryInterface;
use App\Modules\Auth\Infrastructure\Mail\ForgotPasswordOtpEmail;
use App\Modules\Auth\Infrastructure\Mappers\UserOtpModelMapper;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;


class ForgotPasswordUseCase
{
    public function __construct(
        protected readonly UserRepositoryInterface $userRepository,
        protected readonly UserOTPRepositoryInterface $otpRepository,
    ) {}

    // TODO : fix me
    public function handle(string $email): ?UserOtpDTO
    {
        // if user email don't exists, through exception
        // if user email exists, generate otp and store otp to table and email OTP to user email
        $user = $this->userRepository->findByEmail(
            $email
        );

        if ($user === null) {
            throw new Exception('Email is not valid', Response::HTTP_NOT_FOUND);
        }

        $userOTP = $this->otpRepository->findUserOTPByUserId(
            $user->getId()
        );

        if ($userOTP === null) {
            // creating user OTP
            $otpValidTime = OTPGenerator::getValidateTime();
            $otp = OTPGenerator::generateOTP();
            $expiresAt = OTPGenerator::generateExpireTime();

            $userOtpModel = new UserOtpEntity(
                id: 0,
                otp: $otp,
                userId: $user->getId(),
                expiresAt: $expiresAt,
                isVerified: true,
            );
            // Persist user in database
            $returnResult = $this->otpRepository->save($userOtpModel);
            Mail::to($user->getEmail())->send(new ForgotPasswordOtpEmail($user->getName(), $otp, $otpValidTime));
        }
        //generate otp and store otp to table and emil to user email
        else {
            // update user OTP
            $otpValidTime = OTPGenerator::getValidateTime();
            $otp = OTPGenerator::generateOTP();
            $expiresAt = OTPGenerator::generateExpireTime();
            $otpToken = Str::random();
            $userOTP = $this->otpRepository->findUserOTPByUserId(
                $user->getId()
            );
            $userOTP->setId($userOTP->getId());
            $userOTP->setUserId($userOTP->getUserId());
            $userOTP->setIsVerified(true);
            // verification status changed then no data will be changed
            if ($userOTP->getIsVerified()) {
                $userOTP->setOtp($userOTP->getOtp());
                $userOTP->setExpiresAt($userOTP->getExpiresAt());
                $userOTP->setToken($otpToken);
            }
            // if verification status, no changed then new otp & otp expiration will be added
            else {
                $userOTP->setOtp($otp);
                $userOTP->setExpiresAt($expiresAt);
                $userOTP->setToken(null);
            }
            $userOTP->setCreatedAt($userOTP->getCreatedAt());
            $userOTP->setUpdatedAt(Carbon::now()->toDateTimeImmutable());
            $returnResult = $this->otpRepository->save($userOTP);
            if ($userOTP->getIsVerified()) {
                Mail::to($email)->send(new ForgotPasswordOtpEmail($user->getName(), $otp, $otpValidTime));
            }
        }
        return UserOtpDTOMapper::toDTO($userOTP);
    }
}
