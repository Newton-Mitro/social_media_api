<?php

namespace App\Modules\Post\Domain\Entities;

use App\Modules\Auth\Application\Resources\UserResource;
use DateTimeImmutable;


class ViewResource
{
    public function __construct(
        public  string $id,
        public  UserResource $viewer,
        public  DateTimeImmutable $viewedAt
    ) {}
}
