<?php

namespace App\Modules\Profile\Infrastructure\Mappers;

use Illuminate\Database\Eloquent\Model;
use App\Modules\Auth\Infrastructure\Mappers\UserAggregateMapper;
use App\Modules\Profile\Domain\Aggregates\ProfileAggregate;

class ProfileAggregateMapper
{
    public static function toAggregate(Model $model, array $counters): ProfileAggregate
    {
        return new ProfileAggregate(
            user: UserAggregateMapper::toAggregate($model),
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
