<?php

namespace App\Modules\Content\Share\Application\DTOs;

use App\Modules\Auth\Domain\Entities\UserEntity;
use App\Modules\Content\Share\Domain\ValueObjects\SharePlatforms;
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
