<?php

namespace App\Modules\Auth\Infrastructure\Mappers;

use App\Modules\Auth\Domain\Entities\UserOtpEntity;
use App\Modules\Auth\Infrastructure\Models\UserOtp;

class UserOtpModelMapper
{
    public static function toModel(UserOtpEntity $entity): UserOtp
    {
        $user = UserOtp::find($entity->getId()) ?? new UserOtp();
        $user->otp = $entity->getOtp();
        $user->user_id = $entity->getUserId();
        $user->is_verified = $entity->getIsVerified();
        $user->token = $entity->getToken();
        $user->otp_expires_at = $entity->getExpiresAt();
        $user->created_at = $entity->getCreatedAt();
        $user->updated_at = $entity->getUpdatedAt();

        return $user;
    }
}
