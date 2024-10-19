<?php

namespace App\Modules\Auth\User\Repositories;

use App\Modules\Auth\User\BusinessModels\UserModel;
use App\Modules\Auth\User\Interfaces\UserRepositoryInterface;
use App\Modules\Auth\User\Mappers\UserMapper;
use App\Modules\Auth\User\Models\User;
use Exception;
use Illuminate\Http\Response;

class UserRepositoryInterfaceImpl implements UserRepositoryInterface
{
    public function findById(int $userId): ?UserModel
    {
        $user = User::find($userId);
        if ($user) {
            return UserMapper::toBusinessModel($user);
        }

        return null;
    }

    public function findUserByEmail(string $email): ?UserModel
    {
        $user = User::where('email', $email)->first();
        if ($user) {
            return UserMapper::toBusinessModel($user);
        }

        return null;
    }

    public function create(UserModel $userModel): UserModel
    {
        try {
            $user = new User;
            $user->name = $userModel->getName();
            $user->user_name = $userModel->getUserName();
            $user->email = $userModel->getEmail();
            $user->password = $userModel->getPassword();
            $user->profile_picture = $userModel->getProfilePicture();
            $user->cover_photo = $userModel->getCoverPhoto();
            $user->email_verified_at = $userModel->getEmailVerifiedAt();
            $user->otp = $userModel->getOtp();
            $user->otp_expires_at = $userModel->getOtpExpiresAt();
            $user->otp_verified = $userModel->isOtpVerified();
            $user->last_logged_in = $userModel->getLastLoggedIn();
            $user->created_at = $userModel->getCreatedAt();
            $user->updated_at = $userModel->getUpdatedAt();
            $user->save();

            return UserMapper::toBusinessModel($user);
        } catch (Exception $exception) {
            throw new Exception($exception->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR, $exception);
        }
    }

    public function update(int $userId, UserModel $userModel): UserModel
    {
        try {
            $user = User::find($userId);
            $user->name = $userModel->getName();
            $user->user_name = $userModel->getUserName();
            $user->email = $userModel->getEmail();
            $user->password = $userModel->getPassword();
            $user->profile_picture = $userModel->getProfilePicture();
            $user->cover_photo = $userModel->getCoverPhoto();
            $user->email_verified_at = $userModel->getEmailVerifiedAt();
            $user->otp = $userModel->getOtp();
            $user->otp_expires_at = $userModel->getOtpExpiresAt();
            $user->otp_verified = $userModel->isOtpVerified();
            $user->last_logged_in = $userModel->getLastLoggedIn();
            $user->created_at = $userModel->getCreatedAt();
            $user->updated_at = $userModel->getUpdatedAt();
            $user->save();

            return UserMapper::toBusinessModel($user);
        } catch (Exception $exception) {
            throw new Exception($exception->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR, $exception);
        }
    }
}
