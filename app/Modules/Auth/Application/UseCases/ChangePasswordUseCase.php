<?php

namespace App\Modules\Auth\Application\UseCases;

use App\Modules\Auth\Domain\Interfaces\UserRepositoryInterface;
use DateTimeImmutable;
use Exception;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;

class ChangePasswordUseCase
{
    public function __construct(
        protected UserRepositoryInterface $userRepository,
    ) {}

    public function handle(string $email, string $oldPassword, string $password): void
    {
        $user = $this->userRepository->findByEmail(
            $email
        );

        if (Hash::check($oldPassword, $user->getPassword())) {
            $user->setPassword($password);
            $user->setUpdatedAt(new DateTimeImmutable);
            $this->userRepository->save($user);
        } else {
            throw new Exception("Password doesn't match", Response::HTTP_BAD_REQUEST);
        }
    }
}
