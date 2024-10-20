<?php

namespace App\Modules\Auth\Authentication\UseCases;

use DateTimeImmutable;
use App\Core\Utilities\OTPGenerator;
use Illuminate\Support\Facades\Mail;
use App\Modules\Auth\Authentication\Mail\VerificationEmail;
use App\Modules\Auth\User\Interfaces\UserRepositoryInterface;

class SendEmailVerifyingOTPCommandHandler
{
    public function __construct(
        protected UserRepositoryInterface $repository,
    ) {}

    public function handle(string $email): void
    {
        $otpValidTime = OTPGenerator::getValidateTime();
        $otp = OTPGenerator::generateOTP();
        $expiresAt = OTPGenerator::generateExpireTime();

        // Find the user by email
        $user = $this->repository->findUserByEmail($email);

        // TODO: Implement UpdateUserCommand
        $user->setOtp($otp);
        $user->setOtpExpiresAt($expiresAt->toDateTimeImmutable());
        $user->setUpdatedAt(new DateTimeImmutable);
        $user->setOtpVerified(false);
        // Persist user to db
        $this->repository->update($user->getUserId(), $user);

        // Send OTP to user email
        Mail::to($user->getEmail())->send(new VerificationEmail($user, $otp, $otpValidTime));
    }
}
