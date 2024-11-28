<?php

namespace App\Modules\Friend\Application\UseCases;

use App\Modules\Friend\Domain\Entities\FriendRequestEntity;
use App\Modules\Friend\Domain\Repositories\FriendRepositoryInterface;
use App\Modules\Friend\Domain\ValueObjects\FriendRequestStatus;


class SendFriendRequestUseCase
{
    private FriendRepositoryInterface $friendRepository;

    public function __construct(FriendRepositoryInterface $friendRepository)
    {
        $this->friendRepository = $friendRepository;
    }

    public function execute(string $senderId, string $receiverId): void
    {
        $existingRequest = $this->friendRepository->findExistingRequest($senderId, $receiverId);

        if ($existingRequest) {
            throw new \Exception('Friend request already exists.');
        }

        $friendRequestEntity = new FriendRequestEntity(
            $senderId,
            $receiverId,
            FriendRequestStatus::PENDING
        );

        $this->friendRepository->save($friendRequestEntity);
    }
}
