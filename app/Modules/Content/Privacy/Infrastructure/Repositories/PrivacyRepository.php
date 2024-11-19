<?php

namespace App\Modules\Content\Privacy\Infrastructure\Repositories;

use App\Modules\Content\Privacy\Domain\Repositories\PrivacyRepositoryInterface;
use App\Modules\Content\Privacy\Infrastructure\Models\Privacy;


class PrivacyRepository implements PrivacyRepositoryInterface
{
    public function getPrivacies()
    {
        return Privacy::all();
    }
}
