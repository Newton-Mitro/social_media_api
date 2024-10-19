<?php

namespace App\Modules\Auth\User\UseCases\Commands\UpdateUser;

use Exception;
use DateTimeImmutable;
use Illuminate\Http\Response;
use App\Modules\Auth\User\BusinessModels\UserModel;
use App\Modules\Auth\User\Interfaces\UserRepositoryInterface;
use App\Modules\Auth\User\UseCases\Queries\FindUser\FindUserQuery;

class UpdateCoverPictureCommandHandler
{
    public function __construct(
        protected UserRepositoryInterface $repository,
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
