<?php

namespace App\Modules\Profile\Application\DTOs;

use App\Modules\Auth\Application\DTOs\UserAggregateDTO;

class ProfileAggregateDTO
{
    public function __construct(
        public UserAggregateDTO $user,
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
