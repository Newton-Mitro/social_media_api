<?php

namespace App\Modules\Friend\Application\DTOs;

class FriendRequestDTO
{
    public string $id;
    public string $senderId;
    public string $receiverId;
    public string $status;
    public string $createdAt;
    public string $updatedAt;

    public function __construct(
        string $id,
        string $senderId,
        string $receiverId,
        string $status,
        string $createdAt,
        string $updatedAt
    ) {
        $this->id = $id;
        $this->senderId = $senderId;
        $this->receiverId = $receiverId;
        $this->status = $status;
        $this->createdAt = $createdAt;
        $this->updatedAt = $updatedAt;
    }
}
