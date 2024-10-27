<?php

namespace App\Modules\Post\Infrastructure\Repositories;

use App\Modules\Post\Core\Interfaces\PrivacyRepositoryInterface;
use App\Modules\Post\Infrastructure\Models\Privacy;

class PrivacyRepository implements PrivacyRepositoryInterface
{
    public function getPrivacies()
    {
        return Privacy::all();
    }
}
