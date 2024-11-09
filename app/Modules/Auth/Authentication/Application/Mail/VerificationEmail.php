<?php

namespace App\Modules\Auth\Authentication\Application\Mail;

use App\Modules\Auth\User\BusinessModels\UserEntity;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class VerificationEmail extends Mailable
{
    use Queueable;
    use SerializesModels;

    public function __construct(public UserEntity $user, public string $otp, public string $otpValidityPeriod) {}

    public function build()
    {
        return $this
            ->subject('Email Verification OTP')
            ->view('emails.verification-email')
            ->with([
                'name' => $this->user->getName(),
                'otp' => $this->otp,
                'otp_validity_period' => $this->otpValidityPeriod,
            ]);
    }
}
