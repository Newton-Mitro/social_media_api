<?php

namespace App\Modules\Auth\User\UseCases;

use Exception;
use DateTimeImmutable;
use Illuminate\Http\Response;
use App\Modules\Auth\User\BusinessModels\UserModel;
use App\Modules\Auth\User\Interfaces\UserRepositoryInterface;
use App\Modules\Auth\User\UseCases\Queries\FindUser\FindUserQuery;

class UpdateProfilePictureCommandHandler
{
    public function __construct(
        protected UserRepositoryInterface $repository,
    ) {}

    public function handle(UpdateProfilePictureCommand $command): ?UserModel
    {
        $user = $this->queryBus->ask(
            new FindUserQuery($command->getUserId())
        );

        $user->setUpdatedAt(new DateTimeImmutable());
        $user->setProfilePicture($command->getProfilePicture());

        if ($this->repository->update($command->getUserId(), $user)) {
            return $user;
        }

        throw new Exception('User update has failed!', Response::HTTP_BAD_REQUEST);
    }
}
