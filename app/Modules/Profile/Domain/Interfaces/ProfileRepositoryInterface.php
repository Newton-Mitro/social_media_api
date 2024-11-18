<?php

namespace App\Modules\Profile\Domain\Interfaces;

use App\Modules\Profile\Domain\Aggregates\ProfileAggregate;

interface ProfileRepositoryInterface
{
    public function fetchUserProfile(string $userId, string $authUserId = null): ?ProfileAggregate;
    public function save(ProfileAggregate $profileAggregate): void;
}
