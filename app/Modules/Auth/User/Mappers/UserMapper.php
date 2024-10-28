<?php

namespace App\Modules\Auth\User\Mappers;

use Carbon\Carbon;
use App\Modules\Auth\User\Models\User;
use App\Modules\Auth\User\Resources\UserResource;
use App\Modules\Auth\User\BusinessModels\UserModel;
use Illuminate\Support\Facades\Storage;

class UserMapper
{
    public static function toBusinessModel(User $user): UserModel
    {
        // $profile_picture_url = config('app.USER_PROFILE_IMAGE_URL').$user->profile_picture;
        // $cover_photo_url = config('app.USER_COVER_IMAGE_URL').$user->cover_photo;
        return new UserModel(
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


    public static function toUserResource(UserModel $userModel): UserResource
    {
        return new UserResource(
            $userModel->getUserId(),
            $userModel->getName(),
            $userModel->getUserName(),
            $userModel->getEmail(),
            $userModel->getProfilePicture(),
            $userModel->getCoverPhoto(),
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
