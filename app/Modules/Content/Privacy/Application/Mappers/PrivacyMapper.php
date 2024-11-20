<?php

namespace App\Modules\Content\Privacy\Application\Mappers;

use App\Modules\Content\Privacy\Application\DTOs\PrivacyDTO;
use App\Modules\Content\Privacy\Domain\Entities\PrivacyEntity;

class PrivacyMapper
{
    public static function toDTO(PrivacyEntity $entity): PrivacyDTO
    {
        $privacyDTO = new PrivacyDTO();
        $privacyDTO->id = $entity->getId();
        $privacyDTO->privacy_name = $entity->getPrivacyName();
        $privacyDTO->created_at = $entity->getCreatedAt()->format('Y-m-d H:i:s');
        $privacyDTO->updated_at = $entity->getUpdatedAt()->format('Y-m-d H:i:s');
        return $privacyDTO;
    }

    public static function toDTOCollection(array $models): array
    {
        return array_map([self::class, 'toDTO'], $models);
    }
}
