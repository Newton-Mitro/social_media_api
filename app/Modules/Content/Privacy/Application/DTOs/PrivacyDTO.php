<?php

namespace App\Modules\Content\Privacy\Application\DTOs;

class PrivacyDTO
{
    public function __construct(
        public string $id,
        public string $name
    ) {}
}
