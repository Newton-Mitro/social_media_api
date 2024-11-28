<?php

namespace App\Modules\Friend\Infrastructure\Mappers;

use App\Modules\Friend\Domain\Entities\FriendRequestEntity;
use App\Modules\Friend\Infrastructure\Models\FriendRequest;
use App\Modules\Friend\Domain\ValueObjects\FriendRequestStatus;
use Illuminate\Support\Collection;

class FriendRequestMapper
{
    public static function toEntity(FriendRequest $model): FriendRequestEntity
    {
        return new FriendRequestEntity(
            $model->sender_id,
            $model->receiver_id,
            FriendRequestStatus::from($model->status),
            new \DateTimeImmutable($model->created_at),
            new \DateTimeImmutable($model->updated_at),
            null,
            null,
            $model->id
        );
    }

    public static function toEntityCollection(Collection $models): Collection
    {
        return $models->map(fn(FriendRequest $model) => self::toEntity($model));
    }

    public static function toModel(FriendRequestEntity $entity): FriendRequest
    {
        return new FriendRequest([
            'id' => $entity->getId(),
            'sender_id' => $entity->getSenderId(),
            'receiver_id' => $entity->getReceiverId(),
            'status' => $entity->getStatus()->value,
            'created_at' => $entity->getCreatedAt()->format(DATE_ATOM),
            'updated_at' => $entity->getUpdatedAt()->format(DATE_ATOM),
        ]);
    }
}
