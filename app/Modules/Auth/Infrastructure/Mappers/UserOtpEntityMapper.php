<?php

namespace App\Modules\Auth\Infrastructure\Mappers;

use App\Modules\Auth\Domain\Entities\UserOtpEntity;
use App\Modules\Auth\Infrastructure\Models\UserOtp;
use DateTimeImmutable;

class UserOtpEntityMapper
{
    public static function toEntity(UserOtp $model): UserOtpEntity
    {
        return new UserOtpEntity(
            id: $model->id,
            otp: $model->otp,
            userId: $model->user_id,
            expiresAt: new DateTimeImmutable($model->expires_at),
            isVerified: $model->is_verified,
            token: $model->token,
            createdAt: new DateTimeImmutable($model->created_at),
            updatedAt: new DateTimeImmutable($model->updated_at)
        );
    }
}
