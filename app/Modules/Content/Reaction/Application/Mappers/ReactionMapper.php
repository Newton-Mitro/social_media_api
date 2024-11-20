<?php

namespace App\Modules\Content\Reaction\Application\Mappers;

use App\Modules\Content\Reaction\Application\DTOs\ReactionDTO;
use App\Modules\Content\Reaction\Domain\Entities\ReactionEntity;

class ReactionMapper
{
    public static function toDTO(ReactionEntity $entity): ReactionDTO
    {
        $reactionDTO = new ReactionDTO();
        $reactionDTO->id = $entity->getId();
        $reactionDTO->reactable_id = $entity->getReactableId();
        $reactionDTO->reactable_type = $entity->getReactableType();
        $reactionDTO->user = $entity->getUser();
        $reactionDTO->type = $entity->getType();
        $reactionDTO->created_at = $entity->getCreatedAt()->format('Y-m-d H:i:s');
        $reactionDTO->updated_at = $entity->getUpdatedAt()->format('Y-m-d H:i:s');

        return $reactionDTO;
    }

    public static function toDTOCollection(array $entities): array
    {
        return array_map([self::class, 'toDTO'], $entities);
    }
}
