<?php

namespace App\Modules\Post\Domain\Entities;

use App\Modules\Auth\Domain\Entities\UserEntity;


class ViewResource
{
    public function __construct(
        public  string $id,
        public  UserEntity $viewer,
        public  \DateTimeImmutable $viewedAt
    ) {}
}
