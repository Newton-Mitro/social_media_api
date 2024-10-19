<?php

namespace App\Features\Auth\Authentication\Mail;

use App\Features\Auth\User\BusinessModels\UserModel;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class VerificationEmail extends Mailable
{
    use Queueable;
    use SerializesModels;

    public function __construct(public UserModel $user, public string $otp, public string $otpValidityPeriod) {}

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
