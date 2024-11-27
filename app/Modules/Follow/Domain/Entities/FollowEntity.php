<?php

namespace App\Modules\Follow\Domain\Entities;

use App\Core\Entities\BaseEntity;
use App\Modules\Auth\Domain\Aggregates\UserAggregate;
use DateTimeImmutable;
use InvalidArgumentException;

class FollowEntity extends BaseEntity
{
    private string $followerId;
    private string $followingId;
    private DateTimeImmutable $createdAt;
    private DateTimeImmutable $updatedAt;
    private ?UserAggregate $follower;
    private ?UserAggregate $following;

    public function __construct(
        string $followerId,
        string $followingId,
        DateTimeImmutable $createdAt = new DateTimeImmutable(),
        DateTimeImmutable $updatedAt = new DateTimeImmutable(),
        ?UserAggregate $follower = null,
        ?UserAggregate $following = null,
        ?string $id = null
    ) {
        parent::__construct($id);

        if ($followerId === $followingId) {
            throw new InvalidArgumentException('A user cannot follow themselves.');
        }

        $this->followerId = $followerId;
        $this->followingId = $followingId;
        $this->createdAt = $createdAt;
        $this->updatedAt = $updatedAt;
        $this->follower = $follower;
        $this->following = $following;
    }

    public function getFollowerId(): string
    {
        return $this->followerId;
    }

    public function getFollowingId(): string
    {
        return $this->followingId;
    }

    public function getFollower(): ?UserAggregate
    {
        return $this->follower;
    }

    public function getFollowing(): ?UserAggregate
    {
        return $this->following;
    }

    public function getCreatedAt(): DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function getUpdatedAt(): DateTimeImmutable
    {
        return $this->updatedAt;
    }

    public function matches(string $followerId, string $followingId): bool
    {
        return $this->followerId === $followerId && $this->followingId === $followingId;
    }

    public function touch(): void
    {
        $this->updatedAt = new DateTimeImmutable();
    }
}
