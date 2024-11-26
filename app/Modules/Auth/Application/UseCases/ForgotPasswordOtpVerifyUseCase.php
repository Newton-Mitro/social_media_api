<?php

namespace App\Modules\Auth\Application\UseCases;

use App\Core\Enums\OtpTypes;
use App\Core\Utilities\OTPGenerator;
use App\Modules\Auth\Application\DTOs\UserOtpDTO;
use App\Modules\Auth\Application\Mappers\UserOtpMapper;
use App\Modules\Auth\Domain\Interfaces\UserOTPRepositoryInterface;
use App\Modules\Auth\Domain\Interfaces\UserRepositoryInterface;
use Carbon\Carbon;
use DateTimeImmutable;
use Exception;
use Illuminate\Http\Response;
use Illuminate\Support\Str;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ForgotPasswordOtpVerifyUseCase
{
    public function __construct(
        protected UserRepositoryInterface $userRepository,
        protected UserOTPRepositoryInterface $userOTPRepository
    ) {}

    public function handle(string $email, string $otp): UserOtpDTO
    {
        $user = $this->userRepository->findByEmail(
            $email
        );
        if (!$user) {
            throw new NotFoundHttpException("User is not registered with this email $email.", null, Response::HTTP_NOT_FOUND);
        }
        //Get user OTP
        $userOTP = $this->userOTPRepository->findUserOTPByUserIdAndType(
            $user->getId(),
            OtpTypes::FORGOT_PASSWORD
        );
        if ($userOTP->getOtp() === $otp && $userOTP->getExpiresAt() > Carbon::now()) {
            // creating user OTP
            $otpValidTime = OTPGenerator::getValidateTime();
            $otp = OTPGenerator::generateOTP();
            $expiresAt = OTPGenerator::generateExpireTime();
            $otpToken = Str::random();

            $userOTP->setIsVerified(true);
            $userOTP->setToken($otpToken);
            $userOTP->setExpiresAt($expiresAt);
            $userOTP->setUpdatedAt(new DateTimeImmutable());
            $this->userOTPRepository->save($userOTP);

            return UserOtpMapper::toDTO($userOTP);
        } else {
            throw new Exception('Invalid OTP', Response::HTTP_BAD_REQUEST);
        }
    }
}
