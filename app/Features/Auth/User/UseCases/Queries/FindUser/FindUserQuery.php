<?php

namespace App\Features\Auth\User\UseCases\Queries\FindUser;

use App\Core\Bus\Query;

class FindUserQuery extends Query
{
    public function __construct(
        private readonly int $id,
    ) {}

    public function getId(): int
    {
        return $this->id;
    }
}
