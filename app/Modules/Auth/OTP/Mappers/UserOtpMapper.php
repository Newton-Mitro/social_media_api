<?php

namespace App\Modules\Auth\OTP\Mappers;

use Carbon\Carbon;
use App\Modules\Auth\OTP\Models\UserOtp;
use App\Modules\Auth\OTP\BusinessModel\UserOtpModel;
use App\Modules\Auth\OTP\Resources\ForgotPasswordOTPResource;
use App\Modules\Auth\OTP\Resources\VeriFyForgotPasswordOTPResource;

class UserOtpMapper
{
    public static function toBusinessModel(UserOtp $userOtp): UserOtpModel
    {
        return new UserOtpModel(
            $userOtp->id,
            $userOtp->otp,
            $userOtp->user_id,
            Carbon::parse($userOtp->expires_at)->toDateTimeImmutable(),
            $userOtp->is_verified,
            $userOtp->token,
            $userOtp->created_at ? Carbon::parse($userOtp->created_at)->toDateTimeImmutable() : null,
            $userOtp->updated_at ? Carbon::parse($userOtp->updated_at)->toDateTimeImmutable() : null
        );
    }

    public static function toEloquentModel(UserOtpModel $userOtpModel): UserOtp
    {
        return new UserOtp([
            'id' => $userOtpModel->getId(),
            'user_id' => $userOtpModel->getUserId(),
            'otp' => $userOtpModel->getOtp(),
            'expires_at' => $userOtpModel->getExpiresAt() ? Carbon::instance($userOtpModel->getCreatedAt()) : null,
            'is_verified' => $userOtpModel->getIsVerified(),
            'token' => $userOtpModel->getToken(),
            'created_at' => $userOtpModel->getCreatedAt() ? Carbon::instance($userOtpModel->getCreatedAt()) : null,
            'updated_at' => $userOtpModel->getUpdatedAt() ? Carbon::instance($userOtpModel->getUpdatedAt()) : null,
        ]);
    }
    public static function toForgotPasswordOTPResource(UserOtpModel $userOtpModel): ForgotPasswordOTPResource
    {
        return new ForgotPasswordOTPResource(
            Carbon::createFromFormat("Y-m-d H:i:s", Carbon::instance($userOtpModel->getUpdatedAt()))
                ->diffInMinutes(Carbon::createFromFormat("Y-m-d H:i:s", Carbon::instance($userOtpModel->getExpiresAt())))
        );
    }
    public static function toVerifyForgotPasswordOTPResource(UserOtpModel $userOtpModel): VeriFyForgotPasswordOTPResource
    {
        return new VeriFyForgotPasswordOTPResource(
            $userOtpModel->getToken()
        );
    }
}
