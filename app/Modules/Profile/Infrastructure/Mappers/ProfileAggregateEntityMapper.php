<?php

namespace App\Modules\Profile\Infrastructure\Mappers;

use Illuminate\Database\Eloquent\Model;
use App\Modules\Auth\Domain\Entities\UserEntity;
use App\Modules\Profile\Domain\Aggregates\ProfileAggregate;
use App\Modules\Profile\Domain\Entities\ProfileEntity;

class ProfileAggregateEntityMapper
{
    public static function fromModel(Model $userModel, ?Model $profileModel, array $counters): ProfileAggregate
    {
        return new ProfileAggregate(
            user: new UserEntity(
                name: $userModel->name,
                email: $userModel->email,
                password: null,
                emailVerifiedAt: $userModel->email_verified_at ? new \DateTimeImmutable($userModel->email_verified_at) : null,
                lastLoggedIn: $userModel->last_logged_in ? new \DateTimeImmutable($userModel->last_logged_in) : null,
                createdAt: new \DateTimeImmutable($userModel->created_at),
                updatedAt: new \DateTimeImmutable($userModel->updated_at),
                id: $userModel->id
            ),
            profile: $profileModel ? new ProfileEntity(
                userId: $profileModel->user_id,
                sex: $profileModel->sex,
                dbo: $profileModel->dbo ? new \DateTimeImmutable($profileModel->dbo) : null,
                mobileNumber: $profileModel->mobile_number,
                profilePicture: $profileModel->profile_picture,
                coverPhoto: $profileModel->cover_photo,
                bio: $profileModel->bio,
                createdAt: new \DateTimeImmutable($profileModel->created_at),
                updatedAt: new \DateTimeImmutable($profileModel->updated_at),
                id: $profileModel->id
            ) : null,
            followers_count: $counters['followers_count'] ?? 0,
            following_count: $counters['following_count'] ?? 0,
            friends_count: $counters['friends_count'] ?? 0,
            friend_requests_count: $counters['friend_requests_count'] ?? 0,
            post_likes_count: $counters['post_likes_count'] ?? 0,
            is_following: $counters['is_following'] ?? false,
            is_user_profile: $counters['is_user_profile'] ?? false,
            friend_request_status: $counters['friend_request_status'] ?? null
        );
    }
}
