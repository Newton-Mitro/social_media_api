<?php

namespace App\Modules\Auth\Infrastructure\Repositories;

use App\Modules\Auth\Domain\Aggregates\UserAggregate;
use App\Modules\Auth\Domain\Interfaces\UserRepositoryInterface;
use App\Modules\Auth\Infrastructure\Mappers\UserAggregateMapper;
use App\Modules\Auth\Infrastructure\Models\User;
use Illuminate\Support\Facades\DB;

class UserRepository implements UserRepositoryInterface
{
    public function findById(string $userId): ?UserAggregate
    {
        $user = User::with('profile')->find($userId);
        if ($user) {
            return UserAggregateMapper::toAggregate($user);
        }

        return null;
    }

    public function findByEmail(string $email): ?UserAggregate
    {
        $user = User::with('profile')->where('email', $email)->first();
        if ($user) {
            return UserAggregateMapper::toAggregate($user);
        }

        return null;
    }

    public function save(UserAggregate $userAggregate): void
    {
        DB::transaction(function () use ($userAggregate) {
            // Save the user details
            $userData = [
                'id' => $userAggregate->getId(),
                'name' => $userAggregate->getName(),
                'email' => $userAggregate->getEmail(),
                'password' => $userAggregate->getPassword(),
                'email_verified_at' => $userAggregate->getEmailVerifiedAt(),
                'last_logged_in' => $userAggregate->getLastLoggedIn(),
                'created_at' => $userAggregate->getCreatedAt(),
                'updated_at' => $userAggregate->getUpdatedAt(),
            ];

            DB::table('users')->updateOrInsert(['id' => $userAggregate->getId()], $userData);

            // Save or update the profile
            $profile = $userAggregate->getProfile();
            $profileData = [
                'user_id' => $profile->getUserId(),
                'sex' => $profile->getSex(),
                'dbo' => $profile->getDbo(),
                'mobile_number' => $profile->getMobileNumber(),
                'profile_picture' => $profile->getProfilePicture(),
                'cover_photo' => $profile->getCoverPhoto(),
                'bio' => $profile->getBio(),
                'created_at' => $profile->getCreatedAt(),
                'updated_at' => $profile->getUpdatedAt(),
            ];

            DB::table('profiles')->updateOrInsert(['user_id' => $profile->getUserId()], $profileData);
        });
    }
}
