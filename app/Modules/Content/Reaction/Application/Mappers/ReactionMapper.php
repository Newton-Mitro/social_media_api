<?php

namespace App\Modules\Content\Reaction\Application\Mappers;

use App\Modules\Content\Reaction\Application\DTOs\ReactionDTO;
use App\Modules\Content\Reaction\Domain\Entities\ReactionEntity;
use DateTimeImmutable;
use Illuminate\Support\Collection;

class ReactionMapper
{
    public static function toDTO(ReactionEntity $entity): ReactionDTO
    {
        $reactionDTO = new ReactionDTO();
        $reactionDTO->id = $entity->getId();
        $reactionDTO->reactable_id = $entity->getReactableId();
        $reactionDTO->reactable_type = $entity->getReactableType();
        $reactionDTO->user_id = $entity->getUserId();
        $reactionDTO->type = $entity->getType();
        $reactionDTO->created_at = $entity->getCreatedAt()->format(DateTimeImmutable::ATOM);
        $reactionDTO->updated_at = $entity->getUpdatedAt()->format(DateTimeImmutable::ATOM);

        return $reactionDTO;
    }

    public static function toDTOCollection(Collection $entities): Collection
    {
        return $entities->map(function (ReactionEntity $entity) {
            return self::toDTO($entity);
        });
    }
}
