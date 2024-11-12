<?php

namespace App\Modules\Post\Domain\Entities;

use App\Modules\Auth\Domain\Entities\UserEntity;


class ShareResource
{
    public function __construct(
        public  string $id,
        public  UserEntity $sharer,
        public  string $platform,
        public  \DateTimeImmutable $sharedAt
    ) {}
}
