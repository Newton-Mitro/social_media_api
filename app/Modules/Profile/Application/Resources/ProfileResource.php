<?php

namespace App\Modules\Profile\Application\Resources;

use App\Modules\Auth\Application\Resources\UserResource;



class ProfileResource
{
    public function __construct(
        public UserResource $user,
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
