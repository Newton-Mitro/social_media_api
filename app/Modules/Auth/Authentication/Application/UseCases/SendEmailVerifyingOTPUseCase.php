<?php

namespace App\Modules\Auth\Authentication\Application\UseCases;

use App\Core\Utilities\OTPGenerator;
use App\Modules\Auth\Authentication\Domain\Interfaces\UserRepositoryInterface;
use App\Modules\Auth\Authentication\Infrastructure\Mail\VerificationEmail;
use DateTimeImmutable;
use Illuminate\Support\Facades\Mail;

class SendEmailVerifyingOTPUseCase
{
    public function __construct(
        protected UserRepositoryInterface $userRepository,
    ) {}

    public function handle(string $email): void
    {
        $otpValidTime = OTPGenerator::getValidateTime();
        $otp = OTPGenerator::generateOTP();
        $expiresAt = OTPGenerator::generateExpireTime();

        // Find the user by email
        $user = $this->userRepository->findByEmail($email);

        // TODO: Implement UpdateUserCommand
        $user->setOtp($otp);
        $user->setOtpExpiresAt($expiresAt->toDateTimeImmutable());
        $user->setUpdatedAt(new DateTimeImmutable);
        $user->setOtpVerified(false);
        // Persist user to db
        $this->userRepository->save($user);

        // Send OTP to user email
        Mail::to($user->getEmail())->send(new VerificationEmail($user, $otp, $otpValidTime));
    }
}
