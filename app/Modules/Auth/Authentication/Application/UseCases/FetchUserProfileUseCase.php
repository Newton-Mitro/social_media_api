<?php

namespace App\Modules\Auth\Authentication\Application\UseCases;

use App\Modules\Auth\Authentication\Domain\Entities\UserEntity;
use App\Modules\Auth\Authentication\Domain\Interfaces\UserRepositoryInterface;
use Exception;
use Illuminate\Http\Response;

class FetchUserProfileUseCase
{
    public function __construct(
        protected UserRepositoryInterface $userRepository,
    ) {}

    public function handle(string $userId): ?UserEntity
    {
        $user = $this->userRepository->findById(
            $userId
        );

        if ($user) {
            return $user;
        }

        throw new Exception('Profile not found.', Response::HTTP_NOT_FOUND);
    }
}
