<?php

namespace App\Modules\Profile\Domain\Interfaces;

use App\Modules\Friend\Domain\Entities\FriendRequestEntity;
use App\Modules\Friend\Domain\ValueObjects\FriendRequestStatus;

interface FriendRepositoryInterface
{
    public function getAll(int $limit = 10, int $offset = 0): array;
    public function save(FriendRequestEntity $friendRequest): void;
    public function findById(string $friendRequestId): ?FriendRequestEntity;
    public function delete(string $friendRequestId): void;
    public function userFriendsCount(string $userId): int;
    public function userFriendRequestsCount(string $userId): int;
    public function userFriendRequestStatus(string $userId, string $authUserId = null): FriendRequestStatus;
}
