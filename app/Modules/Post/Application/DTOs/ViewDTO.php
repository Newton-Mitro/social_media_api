<?php

namespace App\Modules\Post\Domain\Entities;

use App\Modules\Auth\Application\DTOs\UserDTO;
use DateTimeImmutable;


class ViewDTO
{
    public function __construct(
        public  string $id,
        public  UserDTO $viewer,
        public  DateTimeImmutable $viewedAt
    ) {}
}
