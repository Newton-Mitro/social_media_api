<?php

namespace App\Modules\Auth\BlacklistedToken\UseCases;

use App\Modules\Auth\BlacklistedToken\Interfaces\BlacklistedTokenRepositoryInterface;

class BlacklistedTokenExistQueryHandler
{
    public function __construct(
        protected readonly BlacklistedTokenRepositoryInterface $repository,
    ) {}

    public function handle(string $token): bool
    {
        return $this->repository->blacklistedTokenExist($token);
    }
}
