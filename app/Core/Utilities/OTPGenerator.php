<?php

namespace App\Core\Utilities;

use Carbon\Carbon;
use DateTimeImmutable;
use Illuminate\Support\Str;

class OTPGenerator
{
    public static function generateOTP()
    {
        $otp = Str::random(6);
        $otp = "123456";
        return $otp;
    }
    public static function generateExpireTime(): DateTimeImmutable
    {
        $otpValidTime = config('app.otp_expire_time');
        $expiresAt = Carbon::now()->addMinutes((int)$otpValidTime);
        return $expiresAt->toImmutable(); // Convert to DateTimeImmutable
    }
    public static function getValidateTime()
    {
        $otpValidTime = config('app.otp_expire_time');
        return $otpValidTime;
    }
}
