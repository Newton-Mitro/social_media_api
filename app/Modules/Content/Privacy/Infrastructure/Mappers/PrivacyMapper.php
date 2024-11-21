<?php

namespace App\Modules\Content\Privacy\Infrastructure\Mappers;

use App\Modules\Content\Privacy\Domain\Entities\PrivacyEntity;
use App\Modules\Content\Privacy\Infrastructure\Models\Privacy;
use DateTimeImmutable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

class PrivacyMapper
{
    public static function toEntity(Privacy $model): PrivacyEntity
    {
        return new PrivacyEntity(
            $model->id,
            $model->privacy_name,
            new DateTimeImmutable($model->created_at),
            new DateTimeImmutable($model->updated_at)
        );
    }

    public static function toEntityCollection(Collection $models): Collection
    {
        return $models->map([self::class, 'toEntity']);
    }

    public static function toModel(PrivacyEntity $entity): Model
    {
        $model = new Model();
        $model->id = $entity->getId();
        $model->privacy_name = $entity->getPrivacyName();
        $model->created_at = $entity->getCreatedAt();
        $model->updated_at = $entity->getUpdatedAt();
        return $model;
    }
}
