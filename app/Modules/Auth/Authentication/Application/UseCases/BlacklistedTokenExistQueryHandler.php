<?php

namespace App\Modules\Auth\Authentication\Application\UseCases;

use App\Modules\Auth\Authentication\Domain\Interfaces\BlacklistedTokenRepositoryInterface;


class BlacklistedTokenExistQueryHandler
{
    public function __construct(
        protected readonly BlacklistedTokenRepositoryInterface $blacklistedTokenRepository,
    ) {}

    public function handle(string $token): bool
    {
        return $this->blacklistedTokenRepository->blacklistedTokenExist($token);
    }
}
