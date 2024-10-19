<?php

namespace App\Modules\Auth\BlacklistedToken\UseCases\Queries\BlackListTokenExist;

use App\Modules\Auth\BlacklistedToken\Interfaces\BlacklistedTokenRepositoryInterface;

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
