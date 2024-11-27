<?php

namespace App\Modules\Friend\Domain\Entities;

use App\Core\Entities\BaseEntity;
use InvalidArgumentException;

class FriendRequest extends BaseEntity
{
    private string $senderId;
    private string $receiverId;
    private string $status;
    private \DateTimeImmutable $createdAt;
    private \DateTimeImmutable $updatedAt;

    const STATUS_PENDING = 'Pending';
    const STATUS_ACCEPTED = 'Accepted';

    private const VALID_STATUSES = [
        self::STATUS_PENDING,
        self::STATUS_ACCEPTED,
    ];

    public function __construct(
        string $senderId,
        string $receiverId,
        string $status = self::STATUS_PENDING,
        \DateTimeImmutable $createdAt,
        \DateTimeImmutable $updatedAt,
        ?string $id = null
    ) {
        parent::__construct($id);
        $this->senderId = $senderId;
        $this->receiverId = $receiverId;
        $this->setStatus($status);
        $this->createdAt = $createdAt;
        $this->updatedAt = $updatedAt;
    }

    public function getSenderId(): string
    {
        return $this->senderId;
    }

    public function getReceiverId(): string
    {
        return $this->receiverId;
    }

    public function getStatus(): string
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

    public function setStatus(string $status): void
    {
        if (!in_array($status, self::VALID_STATUSES)) {
            throw new InvalidArgumentException("Invalid status: {$status}");
        }
        $this->status = $status;
    }

    public function accept(): void
    {
        $this->setStatus(self::STATUS_ACCEPTED);
        $this->updatedAt = new \DateTimeImmutable();
    }

    public function isPending(): bool
    {
        return $this->status === self::STATUS_PENDING;
    }

    public function isAccepted(): bool
    {
        return $this->status === self::STATUS_ACCEPTED;
    }
}
