<?php

namespace App\Modules\Auth\User\UseCases\Queries\FindUser;

use App\Modules\Auth\User\BusinessModels\UserModel;
use App\Modules\Auth\User\Interfaces\UserRepositoryInterface;

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
