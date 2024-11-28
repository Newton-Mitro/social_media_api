<?php

namespace App\Modules\Friend\Infrastructure\Repositories;

use App\Modules\Auth\Infrastructure\Mappers\UserAggregateMapper;
use App\Modules\Auth\Infrastructure\Models\User;
use App\Modules\Friend\Domain\Entities\FriendRequestEntity;
use App\Modules\Friend\Domain\Repositories\FriendRepositoryInterface;
use App\Modules\Friend\Domain\ValueObjects\FriendRequestStatus;
use App\Modules\Friend\Infrastructure\Mappers\FriendRequestMapper;
use App\Modules\Friend\Infrastructure\Models\FriendRequest;
use Illuminate\Support\Collection;

class FriendRepository implements FriendRepositoryInterface
{
    public function findExistingRequest(string $senderId, string $receiverId): ?FriendRequestEntity
    {
        $request = FriendRequest::with(['sender', 'receiver'])->where(function ($query) use ($senderId, $receiverId) {
            $query->where('sender_id', $senderId)->where('receiver_id', $receiverId);
        })->orWhere(function ($query) use ($senderId, $receiverId) {
            $query->where('sender_id', $receiverId)->where('receiver_id', $senderId);
        })->first();

        return $request ?  FriendRequestMapper::toEntity($request) : null;
    }

    public function findFriends(string $userId): Collection
    {
        // Query the friend requests where the user is either the sender or receiver and the status is ACCEPTED
        $friendRequests = FriendRequest::with(['sender', 'receiver'])
            ->where(function ($query) use ($userId) {
                $query->where('sender_id', $userId)
                    ->orWhere('receiver_id', $userId);
            })
            ->where('status', FriendRequestStatus::ACCEPTED->value)
            ->get();

        // Extract unique friend IDs excluding the user's ID
        $friendIds = $friendRequests->map(function (FriendRequest $friendRequest) use ($userId) {
            return $friendRequest->sender_id === $userId
                ? $friendRequest->receiver_id
                : $friendRequest->sender_id;
        })->unique();

        // Fetch user models for the friend IDs
        $friends = User::with(['profile'])->whereIn('id', $friendIds)->get();

        // Map to UserAggregate using the mapper
        return UserAggregateMapper::toAggregateCollection($friends);
    }

    public function save(FriendRequestEntity $friendRequest): void
    {
        FriendRequest::updateOrCreate(
            ['id' => $friendRequest->getId()],
            [
                'sender_id' => $friendRequest->getSenderId(),
                'receiver_id' => $friendRequest->getReceiverId(),
                'status' => $friendRequest->getStatus()->value,
            ]
        );
    }

    public function findById(string $friendRequestId): ?FriendRequestEntity
    {
        $friendRequest = FriendRequest::with(['sender', 'receiver'])->find($friendRequestId);
        return $friendRequest ? FriendRequestMapper::toEntity($friendRequest) : null;
    }

    public function delete(string $friendRequestId): void
    {
        FriendRequest::where('id', $friendRequestId)->delete();
    }

    public function friendRequestCountByStatus(string $userId, FriendRequestStatus $status): int
    {
        $friends =  FriendRequest::with(['sender', 'receiver'])->where(function ($query) use ($userId) {
            $query->where('sender_id', $userId)->orWhere('receiver_id', $userId);
        })->where('status', $status->value)
            ->count();

        return $friends;
    }
}
