<?php

namespace App\Modules\Auth\BlacklistedToken\UseCases\Commands\AddBlackListToken;

use App\Modules\Auth\BlacklistedToken\BusinessModels\BlacklistedTokenModel;
use App\Modules\Auth\BlacklistedToken\Interfaces\BlacklistedTokenRepositoryInterface;

class AddTokenToBlackListCommandHandler
{
    public function __construct(
        protected readonly BlacklistedTokenRepositoryInterface $repository,
    ) {}

    public function handle(AddTokenToBlackListCommand $command): int
    {
        $addBlackListToken = new BlacklistedTokenModel(
            id: 0,
            token: $command->getToken(),
        );

        return $this->repository->addTokenToBlackList($addBlackListToken);
    }
}
