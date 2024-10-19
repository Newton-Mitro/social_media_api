<?php

namespace App\Features\Auth\Authentication\UseCases\Commands\SendEmailVerifyingOTP;

use DateTimeImmutable;
use App\Core\Utilities\OTPGenerator;
use Illuminate\Support\Facades\Mail;
use App\Features\Auth\Authentication\Mail\VerificationEmail;
use App\Features\Auth\User\Interfaces\UserRepositoryInterface;
use App\Features\Auth\User\UseCases\Queries\FindUserByEmail\FindUserByEmailQuery;

class SendEmailVerifyingOTPCommandHandler
{
    public function __construct(
        protected UserRepositoryInterface $repository,
    ) {}

    public function handle(SendEmailVerifyingOTPCommand $command): void
    {
        $otpValidTime = OTPGenerator::getValidateTime();
        $otp = OTPGenerator::generateOTP();
        $expiresAt = OTPGenerator::generateExpireTime();

        // Find the user by email
        $user = $this->queryBus->ask(
            new FindUserByEmailQuery($command->getEmail())
        );

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
