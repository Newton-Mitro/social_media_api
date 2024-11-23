<?php

namespace App\Modules\Content\Privacy\Infrastructure\Repositories;

use App\Modules\Content\Privacy\Domain\Entities\PrivacyEntity;
use App\Modules\Content\Privacy\Domain\Repositories\PrivacyRepositoryInterface;
use App\Modules\Content\Privacy\Infrastructure\Mappers\PrivacyMapper;
use App\Modules\Content\Privacy\Infrastructure\Models\Privacy;
use Illuminate\Support\Collection;

class PrivacyRepository implements PrivacyRepositoryInterface
{
    public function getPrivacies(): Collection
    {
        $privacies = Privacy::all();
        return PrivacyMapper::toEntityCollection($privacies);
    }

    public function findById(string $id): ?PrivacyEntity
    {
        $privacy = Privacy::find($id);
        if ($privacy) {
            return PrivacyMapper::toEntity($privacy);
        }

        return null;
    }
}
