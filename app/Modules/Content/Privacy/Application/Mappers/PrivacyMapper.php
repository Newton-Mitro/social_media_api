<?php

namespace App\Modules\Content\Privacy\Application\Mappers;

use App\Modules\Content\Privacy\Application\DTOs\PrivacyDTO;
use App\Modules\Content\Privacy\Domain\Entities\PrivacyEntity;
use DateTimeImmutable;
use Illuminate\Support\Collection;

class PrivacyMapper
{
    public static function toDTO(PrivacyEntity $entity): PrivacyDTO
    {
        $privacyDTO = new PrivacyDTO();
        $privacyDTO->id = $entity->getId();
        $privacyDTO->privacy_name = $entity->getPrivacyName();
        $privacyDTO->created_at = $entity->getCreatedAt()->format(DateTimeImmutable::ATOM);
        $privacyDTO->updated_at = $entity->getUpdatedAt()->format(DateTimeImmutable::ATOM);
        return $privacyDTO;
    }

    public static function toDTOCollection(Collection $entities): Collection
    {
        return $entities->map([self::class, 'toDTO']);
    }
}
