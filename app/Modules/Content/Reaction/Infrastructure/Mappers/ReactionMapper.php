<?php

namespace App\Modules\Content\Reaction\Infrastructure\Mappers;

use App\Modules\Content\Reaction\Domain\Entities\ReactionEntity;
use App\Modules\Content\Reaction\Domain\ValueObjects\ReactionTypes;
use App\Modules\Content\Reaction\Infrastructure\Models\Reaction;
use Illuminate\Support\Collection;

class ReactionMapper
{
    public static function toEntity(Reaction $model): ReactionEntity
    {
        return new ReactionEntity(
            id: $model->id,
            reactableId: $model->reactable_id,
            reactableType: $model->reactable_type,
            userId: $model->user_id,
            type: ReactionTypes::from($model->type),
            createdAt: new \DateTimeImmutable($model->created_at),
            updatedAt: new \DateTimeImmutable($model->updated_at)
        );
    }

    public static function toEntityCollection(Collection $models): Collection
    {
        return $models->map(function (Reaction $model) {
            return self::toEntity($model);
        });
    }

    public static function toModel(ReactionEntity $entity): Reaction
    {
        return new Reaction([
            'id' => $entity->getId(),
            'reactable_id' => $entity->getReactableId(),
            'reactable_type' => $entity->getReactableType(),
            'user_id' => $entity->getUserId(),
            'type' => $entity->getType(),
            'created_at' => $entity->getCreatedAt(),
            'updated_at' => $entity->getUpdatedAt(),
        ]);
    }

    public static function toModelCollection(Collection $entities): Collection
    {
        return $entities->map(function (ReactionEntity $entity) {
            return self::toModel($entity);
        });
    }
}
