<?php

namespace App\Modules\Auth\Infrastructure\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ForgotPasswordOtpEmail extends Mailable
{
    use Queueable;
    use SerializesModels;

    public $user;

    public function __construct(public string $userName, public string $otp, public string $expireWithinTime) {}

    public function build()
    {
        return $this
            ->subject('Forgot password OTP')
            ->view('emails.forgot-password-otp-email')
            ->with([
                'name' => $this->userName,
                'otp' => $this->otp,
                'otp_validity_period' => $this->expireWithinTime,
            ]);
    }
}
