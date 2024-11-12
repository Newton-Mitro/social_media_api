<?php

namespace App\Modules\Auth\Infrastructure\Mappers;


use App\Modules\Auth\Domain\Entities\UserEntity;
use App\Modules\Auth\Infrastructure\Models\User;
use DateTimeImmutable;

class UserEntityMapper
{
    public static function toEntity(User $model): UserEntity
    {
        return new UserEntity(
            id: $model->id,
            name: $model->name,
            userName: $model->user_name,
            email: $model->email,
            password: $model->password,
            profilePicture: $model->profile_picture,
            coverPhoto: $model->cover_photo,
            emailVerifiedAt: $model->email_verified_at ? new DateTimeImmutable($model->email_verified_at) : null,
            otp: $model->otp,
            otpExpiresAt: $model->otp_expires_at ? new DateTimeImmutable($model->otp_expires_at) : null,
            otpVerified: $model->otp_verified,
            lastLoggedIn: $model->last_logged_in ? new DateTimeImmutable($model->last_logged_in) : null,
            createdAt: new DateTimeImmutable($model->created_at),
            updatedAt: new DateTimeImmutable($model->updated_at)
        );
    }
}
