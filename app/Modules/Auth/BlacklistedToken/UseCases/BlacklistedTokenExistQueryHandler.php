<?php

namespace App\Features\Auth\BlacklistedToken\UseCases\Queries\BlackListTokenExist;

use App\Features\Auth\BlacklistedToken\Interfaces\BlacklistedTokenRepositoryInterface;

class BlacklistedTokenExistQueryHandler
{
    public function __construct(
        protected readonly BlacklistedTokenRepositoryInterface $repository,
    ) {}

    public function handle(BlacklistedTokenExistQuery $query): bool
    {
        return $this->repository->blacklistedTokenExist($query->getToken());
    }
}
