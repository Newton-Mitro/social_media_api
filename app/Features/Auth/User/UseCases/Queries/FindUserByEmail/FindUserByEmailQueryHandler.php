<?php

namespace App\Features\Auth\User\UseCases\Queries\FindUserByEmail;

use App\Core\Bus\QueryHandler;
use App\Features\Auth\User\BusinessModels\UserModel;
use App\Features\Auth\User\Interfaces\UserRepositoryInterface;

class FindUserByEmailQueryHandler extends QueryHandler
{
    public function __construct(
        protected readonly UserRepositoryInterface $repository,
    ) {}

    public function handle(FindUserByEmailQuery $query): ?UserModel
    {
        return $this->repository->findUserByEmail(
            $query->getEmail(),
        );
    }
}
