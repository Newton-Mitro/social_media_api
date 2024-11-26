<?php

namespace App\Modules\Auth\Application\UseCases;

use App\Core\Enums\OtpTypes;
use App\Core\Utilities\OTPGenerator;
use App\Modules\Auth\Application\DTOs\UserOtpDTO;
use App\Modules\Auth\Application\Mappers\UserOtpMapper;
use App\Modules\Auth\Domain\Entities\UserOtpEntity;
use App\Modules\Auth\Domain\Interfaces\UserOTPRepositoryInterface;
use App\Modules\Auth\Domain\Interfaces\UserRepositoryInterface;
use App\Modules\Auth\Infrastructure\Mail\ForgotPasswordOtpEmail;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;


class ForgotPasswordUseCase
{
    public function __construct(
        protected readonly UserRepositoryInterface $userRepository,
        protected readonly UserOTPRepositoryInterface $otpRepository,
    ) {}

    public function handle(string $email): ?UserOtpDTO
    {
        $user = $this->userRepository->findByEmail(
            $email
        );

        if ($user === null) {
            throw new NotFoundHttpException("User is not registered with this email $email.", null, Response::HTTP_NOT_FOUND);
        }

        $userOTP = $this->otpRepository->findUserOTPByUserIdAndType(
            $user->getId(),
            OtpTypes::FORGOT_PASSWORD
        );

        $otpValidTime = OTPGenerator::getValidateTime();
        $otp = OTPGenerator::generateOTP();
        $expiresAt = OTPGenerator::generateExpireTime();
        $otpToken = Str::random();

        if ($userOTP === null) {
            $userOtpModel = new UserOtpEntity(
                userId: $user->getId(),
                type: OtpTypes::FORGOT_PASSWORD,
                otp: $otp,
                expiresAt: $expiresAt,
                isVerified: false,
                token: $otpToken
            );
            // Persist user in database
            $this->otpRepository->save($userOtpModel);
            Mail::to($user->getEmail())->send(new ForgotPasswordOtpEmail($user->getName(), $otp, $otpValidTime));
            return UserOtpMapper::toDTO($userOtpModel);
        }
        //generate otp and store otp to table and emil to user email
        else {
            // update user OTP
            $userOTP->setOtp($otp);
            $userOTP->setToken($otpToken);
            $userOTP->setExpiresAt($expiresAt);
            $userOTP->setUpdatedAt(Carbon::now()->toDateTimeImmutable());
            $this->otpRepository->save($userOTP);
            Mail::to($email)->send(new ForgotPasswordOtpEmail($user->getName(), $otp, $otpValidTime));

            return UserOtpMapper::toDTO($userOTP);
        }
    }
}
