<?php

namespace App\Modules\Profile\Application\DTOs;

use App\Modules\Auth\Application\DTOs\UserDTO;
use App\Modules\Friend\Domain\ValueObjects\FriendRequestStatus;



class UserProfileDTO
{
    public function __construct(
        public UserDTO $user,
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
