<?php

namespace App\Modules\Auth\BlacklistedToken\UseCases;

use App\Modules\Auth\BlacklistedToken\BusinessModels\BlacklistedTokenModel;
use App\Modules\Auth\BlacklistedToken\Interfaces\BlacklistedTokenRepositoryInterface;

class AddTokenToBlackListCommandHandler
{
    public function __construct(
        protected readonly BlacklistedTokenRepositoryInterface $repository,
    ) {}

    public function handle(string $token): int
    {
        $addBlackListToken = new BlacklistedTokenModel(
            id: 0,
            token: $token
        );

        return $this->repository->addTokenToBlackList($addBlackListToken);
    }
}
