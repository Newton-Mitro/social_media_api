<?php

namespace App\Modules\Post\Domain\Entities;

use App\Modules\Auth\Domain\Entities\UserEntity;
use App\Modules\Post\Domain\Enums\SharePlatforms;
use DateTimeImmutable;


class ShareDTO
{
    public function __construct(
        public  string $id,
        public  UserEntity $sharer,
        public  SharePlatforms $platform,
        public  DateTimeImmutable $sharedAt
    ) {}
}
