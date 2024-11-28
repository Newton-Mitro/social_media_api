<?php

namespace App\Modules\Friend\Domain\Entities;

use App\Core\Entities\BaseEntity;
use App\Modules\Auth\Domain\Aggregates\UserAggregate;
use App\Modules\Friend\Domain\ValueObjects\FriendRequestStatus;
use DateTimeImmutable;

class FriendRequestEntity extends BaseEntity
{
    private string $senderId;
    private string $receiverId;
    private ?UserAggregate $sender;
    private ?UserAggregate $receiver;
    private FriendRequestStatus $status;
    private \DateTimeImmutable $createdAt;
    private \DateTimeImmutable $updatedAt;

    public function __construct(
        string $senderId,
        string $receiverId,
        FriendRequestStatus $status = FriendRequestStatus::PENDING,
        \DateTimeImmutable $createdAt = new DateTimeImmutable(),
        \DateTimeImmutable $updatedAt = new DateTimeImmutable(),
        ?UserAggregate $sender = null,
        ?UserAggregate $receiver = null,
        ?string $id = null
    ) {
        parent::__construct($id);
        $this->senderId = $senderId;
        $this->receiverId = $receiverId;
        $this->status = $status;
        $this->createdAt = $createdAt;
        $this->updatedAt = $updatedAt;
        $this->sender = $sender;
        $this->receiver = $receiver;
    }

    public function getSenderId(): string
    {
        return $this->senderId;
    }

    public function getReceiverId(): string
    {
        return $this->receiverId;
    }

    public function getSender(): ?UserAggregate
    {
        return $this->sender;
    }

    public function getReceiver(): ?UserAggregate
    {
        return $this->receiver;
    }

    public function getStatus(): FriendRequestStatus
    {
        return $this->status;
    }

    public function getCreatedAt(): \DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function getUpdatedAt(): \DateTimeImmutable
    {
        return $this->updatedAt;
    }

    public function setStatus(FriendRequestStatus $status): void
    {
        $this->status = $status;
    }

    public function isPending(): bool
    {
        return $this->status === FriendRequestStatus::PENDING;
    }

    public function isAccepted(): bool
    {
        return $this->status === FriendRequestStatus::ACCEPTED;
    }
}
