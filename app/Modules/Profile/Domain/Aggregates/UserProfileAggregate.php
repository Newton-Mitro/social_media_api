<?php

namespace App\Modules\Profile\Domain\Aggregates;

use App\Modules\Auth\Domain\Entities\UserEntity;
use App\Modules\Friend\Domain\ValueObjects\FriendRequestStatus;

class UserProfileAggregate
{
    public function __construct(
        public UserEntity $user,
        public int $followers_count,
        public int $following_count,
        public int $friends_count,
        public int $friend_requests_count,
        public int $post_likes_count,
        public bool $is_following,
        public bool $is_user_profile,
        public FriendRequestStatus $friend_request_status
    ) {}
}
