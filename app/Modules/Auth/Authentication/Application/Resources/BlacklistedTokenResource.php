<?php

namespace App\Modules\Auth\Authentication\Application\Resources;


class BlacklistedTokenResource
{
    public function __construct(
        public string $id,
        public string $token,
    ) {}
}
