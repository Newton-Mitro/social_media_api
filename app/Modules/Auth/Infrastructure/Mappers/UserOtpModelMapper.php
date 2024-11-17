<?php

namespace App\Modules\Auth\Infrastructure\Mappers;

use App\Modules\Auth\Domain\Entities\UserOtpEntity;
use App\Modules\Auth\Infrastructure\Models\UserOtp;

class UserOtpModelMapper
{
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
