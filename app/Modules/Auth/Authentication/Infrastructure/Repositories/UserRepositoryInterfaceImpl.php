<?php

namespace App\Modules\Auth\Authentication\Infrastructure\Repositories;

use App\Modules\Auth\Authentication\Domain\Entities\UserEntity;
use App\Modules\Auth\Authentication\Domain\Interfaces\UserRepositoryInterface;
use App\Modules\Auth\Authentication\Infrastructure\Mappers\UserMapper;
use App\Modules\Auth\Authentication\Infrastructure\Models\User;
use DateTimeImmutable;
use Exception;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

class UserRepositoryInterfaceImpl implements UserRepositoryInterface
{
    public function findById(string $userId): ?UserEntity
    {
        $user = User::find($userId);
        if ($user) {
            return new UserEntity(
                id: $user->id,
                name: $user->name,
                userName: $user->user_name,
                email: $user->email,
                password: $user->password,
                profilePicture: $user->profile_picture,
                coverPhoto: $user->cover_photo,
                emailVerifiedAt: $user->email_verified_at ? new DateTimeImmutable($user->email_verified_at) : null,
                otp: $user->otp,
                otpExpiresAt: $user->otp_expires_at ? new DateTimeImmutable($user->otp_expires_at) : null,
                otpVerified: $user->otp_verified,
                lastLoggedIn: $user->last_logged_in ? new DateTimeImmutable($user->last_logged_in) : null,
                createdAt: new DateTimeImmutable($user->created_at),
                updatedAt: new DateTimeImmutable($user->updated_at)
            );
        }

        return null;
    }

    public function findByEmail(string $email): ?UserEntity
    {
        $user = User::where('email', $email)->first();
        if ($user) {
            return new UserEntity(
                id: $user->id,
                name: $user->name,
                userName: $user->user_name,
                email: $user->email,
                password: $user->password,
                profilePicture: $user->profile_picture,
                coverPhoto: $user->cover_photo,
                emailVerifiedAt: $user->email_verified_at ? new DateTimeImmutable($user->email_verified_at) : null,
                otp: $user->otp,
                otpExpiresAt: $user->otp_expires_at ? new DateTimeImmutable($user->otp_expires_at) : null,
                otpVerified: $user->otp_verified,
                lastLoggedIn: $user->last_logged_in ? new DateTimeImmutable($user->last_logged_in) : null,
                createdAt: new DateTimeImmutable($user->created_at),
                updatedAt: new DateTimeImmutable($user->updated_at)
            );
        }

        return null;
    }

    public function save(UserEntity $userModel): void
    {
        DB::transaction(function () use ($userModel) {
            $user = User::find($userModel->getId()) ?? new User();
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
        });
    }
}
