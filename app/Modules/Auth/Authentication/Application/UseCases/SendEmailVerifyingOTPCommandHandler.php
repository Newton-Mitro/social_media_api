<?php

namespace App\Modules\Auth\Authentication\Application\UseCases;

use App\Core\Utilities\OTPGenerator;
use App\Modules\Auth\Authentication\Application\Mail\VerificationEmail;
use App\Modules\Auth\Authentication\Domain\Interfaces\UserRepositoryInterface;
use DateTimeImmutable;
use Illuminate\Support\Facades\Mail;

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
