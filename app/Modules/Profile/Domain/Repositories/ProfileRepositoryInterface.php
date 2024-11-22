<?php

namespace App\Modules\Profile\Domain\Repositories;

use App\Modules\Profile\Domain\Aggregates\ProfileAggregate;

interface ProfileRepositoryInterface
{
    public function fetchUserProfile(string $userId, string $authUserId = null): ?ProfileAggregate;
}
