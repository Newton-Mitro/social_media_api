<?php

namespace App\Modules\Follow\Application\DTOs;

use App\Modules\Auth\Application\DTOs\UserAggregateDTO;

class FollowDTO
{
    public function __construct(
        public string $id,
        public string $follower_id,
        public string $following_id,
        public ?UserAggregateDTO $follower,
        public ?UserAggregateDTO $following,
        public string $created_at,
        public string $updated_at
    ) {}
}
