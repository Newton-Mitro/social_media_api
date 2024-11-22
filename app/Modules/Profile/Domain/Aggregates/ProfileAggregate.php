<?php

namespace App\Modules\Profile\Domain\Aggregates;

use App\Modules\Auth\Domain\Aggregates\UserAggregate;

class ProfileAggregate
{
    public function __construct(
        public UserAggregate $user,
        public int $followers_count,
        public int $following_count,
        public int $friends_count,
        public int $friend_requests_count,
        public int $post_likes_count,
        public bool $is_following,
        public bool $is_user_profile,
        public ?string $friend_request_status
    ) {}
}
