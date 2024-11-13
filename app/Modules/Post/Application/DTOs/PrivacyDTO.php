<?php

namespace App\Modules\Post\Domain\Entities;

class PrivacyDTO
{
    public function __construct(
        public string $id,
        public string $name
    ) {}
}
