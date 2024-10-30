<?php

namespace App\Modules\Auth\User\UseCases;

use App\Modules\Auth\User\BusinessModels\UserModel;
use App\Modules\Auth\User\Interfaces\UserRepositoryInterface;
use Exception;
use Illuminate\Http\Response;

class FetchUserProfileUseCase
{
    public function __construct(
        protected UserRepositoryInterface $userRepository,
    ) {}

    public function handle(string $userId): ?UserModel
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
