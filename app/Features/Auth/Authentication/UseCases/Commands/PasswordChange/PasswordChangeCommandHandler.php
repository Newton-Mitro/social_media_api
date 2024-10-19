<?php

namespace App\Features\Auth\Authentication\UseCases\Commands\PasswordChange;

use App\Core\Bus\CommandHandler;
use App\Core\Bus\IQueryBus;
use App\Features\Auth\User\Interfaces\UserRepositoryInterface;
use App\Features\Auth\User\UseCases\Queries\FindUserByEmail\FindUserByEmailQuery;
use DateTimeImmutable;
use Exception;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;

class PasswordChangeCommandHandler extends CommandHandler
{
    public function __construct(
        protected IQueryBus $queryBus,
        protected UserRepositoryInterface $repository,
    ) {}

    public function handle(PasswordChangeCommand $command): string
    {
        $user = $this->queryBus->ask(
            new FindUserByEmailQuery($command->getEmail())
        );

        if (Hash::check($command->getOldPassword(), $user->getPassword())) {
            $user->setPassword($command->getPassword());
            $user->setUpdatedAt(new DateTimeImmutable);
            $this->repository->update($user->getUserId(), $user);

            return 'Your password has been updated!';
        }

        throw new Exception("Password doesn't match", Response::HTTP_BAD_REQUEST);
    }
}
