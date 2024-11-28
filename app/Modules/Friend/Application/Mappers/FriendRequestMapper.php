<?php

namespace App\Modules\Friend\Application\Mappers;

use App\Modules\Friend\Application\DTOs\FriendRequestDTO;
use App\Modules\Friend\Domain\Entities\FriendRequestEntity;
use Illuminate\Support\Collection;

class FriendRequestMapper
{
    public static function toDTO(FriendRequestEntity $entity): FriendRequestDTO
    {
        return new FriendRequestDTO(
            $entity->getId(),
            $entity->getSenderId(),
            $entity->getReceiverId(),
            $entity->getStatus()->value,
            $entity->getCreatedAt()->format(DATE_ATOM),
            $entity->getUpdatedAt()->format(DATE_ATOM)
        );
    }

    public static function toDTOCollection(Collection $entities): Collection
    {
        return $entities->map(fn(FriendRequestEntity $entity) => self::toDTO($entity));
    }
}
