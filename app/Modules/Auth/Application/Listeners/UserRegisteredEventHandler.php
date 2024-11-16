<?php

namespace App\Modules\Auth\Application\Listeners;

use App\Core\Utilities\OTPGenerator;
use App\Modules\Auth\Application\Events\UserRegistered;
use App\Modules\Auth\Domain\Entities\UserOtpEntity;
use App\Modules\Auth\Domain\Interfaces\UserOTPRepositoryInterface;
use App\Modules\Auth\Infrastructure\Mail\VerificationEmail;
use App\Modules\Auth\Infrastructure\Mail\WelcomeEmail;
use DateTimeImmutable;
use Illuminate\Support\Facades\Mail;

class UserRegisteredEventHandler
{
    public function __construct(protected UserOTPRepositoryInterface $userOtpRepository,)
    {
        //
    }

    public function handle(UserRegistered $event): void
    {
        // Send welcome email
        Mail::to($event->user->getEmail())->send(new WelcomeEmail($event->user));

        // Generate OTP
        $otpValidTime = OTPGenerator::getValidateTime();
        $otp = OTPGenerator::generateOTP();
        $expiresAt = OTPGenerator::generateExpireTime();

        // Store OTP/Persist user to db
        $this->userOtpRepository->save(new UserOtpEntity(
            id: 0,
            otp: $otp,
            type: 'UserRegister',
            userId: $event->user->getId(),
            expiresAt: $expiresAt,
            isVerified: false,
            token: null,
            createdAt: new DateTimeImmutable,
            updatedAt: new DateTimeImmutable
        ));

        // Send OTP to user email
        Mail::to($event->user->getEmail())->send(new VerificationEmail($event->user, $otp, $otpValidTime));
    }
}
