<?php

namespace App\Features\Auth\BlacklistedToken\UseCases\Commands\AddBlackListToken;

use App\Core\Bus\CommandHandler;
use App\Features\Auth\BlacklistedToken\BusinessModels\BlacklistedTokenModel;
use App\Features\Auth\BlacklistedToken\Interfaces\BlacklistedTokenRepositoryInterface;
use Illuminate\Support\Str;

class AddTokenToBlackListCommandHandler extends CommandHandler
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
