<?php

namespace App\Modules\Profile\Application\Mappers;

use App\Modules\Auth\Application\Mappers\UserDTOMapper;
use App\Modules\Profile\Application\DTOs\ProfileAggregateDTO;
use App\Modules\Profile\Domain\Aggregates\ProfileAggregate;

class ProfileAggregateDTOMapper
{
    public static function toDTO(ProfileAggregate $entity): ProfileAggregateDTO
    {
        return new ProfileAggregateDTO(
            user: UserDTOMapper::toDTO($entity->user),
            profile: UserDTOMapper::toDTO($entity->user),
            followers_count: $entity->followers_count,
            following_count: $entity->following_count,
            friends_count: $entity->friends_count,
            friend_requests_count: $entity->friend_requests_count,
            post_likes_count: $entity->post_likes_count,
            is_following: $entity->is_following,
            is_user_profile: $entity->is_user_profile,
            friend_request_status: $entity->friend_request_status
        );
    }
}
