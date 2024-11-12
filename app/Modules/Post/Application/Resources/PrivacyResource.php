<?php

namespace App\Modules\Post\Domain\Entities;

class PrivacyResource
{
    public function __construct(
        public string $id,
        public string $name
    ) {}
}
