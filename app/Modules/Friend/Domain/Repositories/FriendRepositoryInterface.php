<?php

namespace App\Modules\Friend\Domain\Repositories;

use App\Modules\Friend\Domain\Entities\FriendRequestEntity;
use App\Modules\Friend\Domain\ValueObjects\FriendRequestStatus;
use Illuminate\Support\Collection;

interface FriendRepositoryInterface
{
    public function findExistingRequest(string $senderId, string $receiverId): ?FriendRequestEntity;
    public function findFriends(string $userId): Collection;
    public function save(FriendRequestEntity $friendRequest): void;
    public function findById(string $friendRequestId): ?FriendRequestEntity;
    public function delete(string $friendRequestId): void;
    public function friendRequestCountByStatus(string $userId, FriendRequestStatus $status): int;
}
