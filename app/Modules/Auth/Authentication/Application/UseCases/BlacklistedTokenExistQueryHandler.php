<?php

namespace App\Modules\Auth\Authentication\Application\UseCases;

use App\Modules\Auth\Authentication\Domain\Interfaces\BlacklistedTokenRepositoryInterface;


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
