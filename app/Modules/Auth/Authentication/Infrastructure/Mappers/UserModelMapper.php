<?php

namespace App\Modules\Auth\Authentication\Infrastructure\Mappers;

use App\Modules\Auth\Authentication\Domain\Entities\UserEntity;
use App\Modules\Auth\Authentication\Infrastructure\Models\User;

class UserModelMapper
{
    public static function toModel(UserEntity $entity): User
    {
        $user = User::find($entity->getId()) ?? new User();
        $user->name = $entity->getName();
        $user->user_name = $entity->getUserName();
        $user->email = $entity->getEmail();
        $user->password = $entity->getPassword();
        $user->profile_picture = $entity->getProfilePicture();
        $user->cover_photo = $entity->getCoverPhoto();
        $user->email_verified_at = $entity->getEmailVerifiedAt();
        $user->otp = $entity->getOtp();
        $user->otp_expires_at = $entity->getOtpExpiresAt();
        $user->otp_verified = $entity->isOtpVerified();
        $user->last_logged_in = $entity->getLastLoggedIn();
        $user->created_at = $entity->getCreatedAt();
        $user->updated_at = $entity->getUpdatedAt();

        return $user;
    }
}
