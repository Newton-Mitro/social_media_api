<?php

namespace App\Modules\Profile\Domain\Interfaces;

use App\Modules\Profile\Domain\Aggregates\UserProfileAggregate;

interface FriendRepositoryInterface
{
    public function fetchUserProfile(string $userId, string $authUserId = null): ?UserProfileAggregate;
}
