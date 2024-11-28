<?php

namespace App\Modules\Friend\Application\UseCases;

use App\Modules\Friend\Domain\Repositories\FriendRepositoryInterface;
use App\Modules\Friend\Domain\ValueObjects\FriendRequestStatus;

class RejectFriendRequestUseCase
{
    private FriendRepositoryInterface $friendRepository;

    public function __construct(FriendRepositoryInterface $friendRepository)
    {
        $this->friendRepository = $friendRepository;
    }

    public function execute(string $requestId, string $receiverId): void
    {
        $friendRequest = $this->friendRepository->findById($requestId);

        if (!$friendRequest || $friendRequest->getReceiverId() !== $receiverId) {
            throw new \Exception('Unauthorized action.');
        }

        $friendRequest->setStatus(FriendRequestStatus::REJECTED);
        $this->friendRepository->save($friendRequest);
    }
}
