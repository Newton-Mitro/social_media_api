<?php
namespace App\Core\Utilities;

use Carbon\Carbon;
use Illuminate\Support\Str;

class OTPGenerator {
    public static function generateOTP() {
        $otp = Str::random(6); // Generate a 6-character OTP
        $otp ="123456";
        return $otp;
    }
   public static function generateExpireTime() {
        $otpValidTime = config('app.otp_expire_time');
        $expiresAt = Carbon::now()->addMinutes((int)$otpValidTime);
        return $expiresAt;
    }
    public static function getValidateTime() {
        $otpValidTime = config('app.otp_expire_time');
        return $otpValidTime;
    }
}
