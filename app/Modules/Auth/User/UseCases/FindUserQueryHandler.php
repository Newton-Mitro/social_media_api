<?php

namespace App\Features\Auth\User\UseCases\Queries\FindUser;

use App\Features\Auth\User\BusinessModels\UserModel;
use App\Features\Auth\User\Interfaces\UserRepositoryInterface;

class FindUserQueryHandler
{
    public function __construct(
        protected readonly UserRepositoryInterface $repository,
    ) {}

    public function handle(FindUserQuery $query): ?UserModel
    {
        return $this->repository->findById(
            $query->getId(),
        );
    }
}
