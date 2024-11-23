<?php

namespace App\Modules\Content\Privacy\Domain\Repositories;

use App\Modules\Content\Privacy\Domain\Entities\PrivacyEntity;
use Illuminate\Support\Collection;

interface PrivacyRepositoryInterface
{
    public function getPrivacies(): Collection;
    public function findById(string $id): ?PrivacyEntity;
}
