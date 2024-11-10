<?php

namespace App\Modules\Auth\Authentication\Infrastructure\Mappers;

use App\Modules\Auth\Authentication\Application\Resources\UserResource;
use App\Modules\Auth\Authentication\Domain\Entities\UserEntity;
use App\Modules\Auth\Authentication\Infrastructure\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;

class UserMapper
{
    public static function toBusinessModel(User $user): UserEntity
    {
        // $profile_picture_url = config('app.USER_PROFILE_IMAGE_URL').$user->profile_picture;
        // $cover_photo_url = config('app.USER_COVER_IMAGE_URL').$user->cover_photo;
        return new UserEntity(
            $user->id,
            $user->name,
            $user->user_name,
            $user->email,
            $user->password,
            $user->profile_picture, //= $profile_picture_url,
            $user->cover_photo, //= $cover_photo_url,
            $user->email_verified_at ? Carbon::parse($user->email_verified_at)->toDateTimeImmutable() : null,
            $user->otp,
            $user->otp_expires_at ? Carbon::parse($user->otp_expires_at)->toDateTimeImmutable() : null,
            $user->otp_verified,
            $user->last_logged_in ? Carbon::parse($user->last_logged_in)->toDateTimeImmutable() : null,
            $user->created_at ? Carbon::parse($user->created_at)->toDateTimeImmutable() : null,
            $user->updated_at ? Carbon::parse($user->updated_at)->toDateTimeImmutable() : null
        );
    }


    public static function toUserResource(UserEntity $userModel): UserResource
    {
        return new UserResource(
            $userModel->getUserId(),
            $userModel->getName(),
            $userModel->getUserName(),
            $userModel->getEmail(),
            $userModel->getProfilePicture() ? asset(Storage::url($userModel->getProfilePicture())) : null,
            $userModel->getCoverPhoto() ? asset(Storage::url($userModel->getCoverPhoto())) : null,
            $userModel->getEmailVerifiedAt() ? $userModel->getEmailVerifiedAt()->format('Y-m-d H:i:s') : null
        );
    }

    public static function toUserResourceCollection(array $listOfUserModel): array
    {
        $users = [];
        foreach ($listOfUserModel as $user) {
            $users[] = self::toUserResource($user);
        }

        return $users;
    }
}
