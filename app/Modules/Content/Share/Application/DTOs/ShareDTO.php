<?php

namespace App\Modules\Content\Share\Application\DTOs;

use App\Modules\Auth\Domain\Entities\UserAggregate;
use App\Modules\Content\Share\Domain\ValueObjects\SharePlatforms;
use DateTimeImmutable;


class ShareDTO
{
    public function __construct(
        public  string $id,
        public  UserAggregate $sharer,
        public  SharePlatforms $platform,
        public  DateTimeImmutable $sharedAt
    ) {}
}
