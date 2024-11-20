<?php

namespace App\Modules\Auth\Infrastructure\Mappers;

use App\Core\Enums\OtpTypes;
use App\Modules\Auth\Domain\Entities\UserOtpEntity;
use App\Modules\Auth\Infrastructure\Models\UserOtp;
use DateTimeImmutable;

class UserOtpMapper
{
    public static function toEntity(UserOtp $model): UserOtpEntity
    {
        return new UserOtpEntity(
            id: $model->id,
            otp: $model->otp,
            userId: $model->user_id,
            type: OtpTypes::from($model->type),
            expiresAt: new DateTimeImmutable($model->expires_at),
            isVerified: $model->is_verified,
            token: $model->token,
            createdAt: new DateTimeImmutable($model->created_at),
            updatedAt: new DateTimeImmutable($model->updated_at)
        );
    }

    public static function toModel(UserOtpEntity $entity): UserOtp
    {
        $model = UserOtp::find($entity->getId()) ?? new UserOtp();
        $model->id = $entity->getId();
        $model->otp = $entity->getOtp();
        $model->user_id = $entity->getUserId();
        $model->is_verified = $entity->getIsVerified();
        $model->type = $entity->getType();
        $model->token = $entity->getToken();
        $model->expires_at = $entity->getExpiresAt();
        $model->created_at = $entity->getCreatedAt();
        $model->updated_at = $entity->getUpdatedAt();

        return $model;
    }
}
