<?php

namespace App\Modules\Content\View\Application\DTOs;

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
