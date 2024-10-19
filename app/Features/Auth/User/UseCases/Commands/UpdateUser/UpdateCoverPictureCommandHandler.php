<?php

namespace App\Features\Auth\User\UseCases\Commands\UpdateUser;

use Exception;
use DateTimeImmutable;
use App\Core\Bus\IQueryBus;
use App\Core\Bus\ICommandBus;
use Illuminate\Http\Response;
use App\Core\Bus\CommandHandler;
use App\Features\Auth\User\BusinessModels\UserModel;
use App\Features\Auth\User\Interfaces\UserRepositoryInterface;
use App\Features\Auth\User\UseCases\Queries\FindUser\FindUserQuery;

class UpdateCoverPictureCommandHandler extends CommandHandler
{
    public function __construct(
        protected UserRepositoryInterface $repository,
        protected ICommandBus $commandBus,
        protected IQueryBus $queryBus,
    ) {}

    public function handle(UpdateCoverPictureCommand $command): ?UserModel
    {

        $user = $this->queryBus->ask(
            new FindUserQuery($command->getUserId())
        );
        $user->setUpdatedAt(new DateTimeImmutable());
        $user->setCoverPhoto($command->getCoverPhoto());

        if ($this->repository->update($command->getUserId(), $user)) {
            return $user;
        }

        throw new Exception('User update has failed!', Response::HTTP_BAD_REQUEST);
    }
}
