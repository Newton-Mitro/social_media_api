<?php

namespace App\Modules\Auth\Authentication\Application\UseCases;

use App\Modules\Auth\Authentication\Domain\Interfaces\UserRepositoryInterface;
use DateTimeImmutable;
use Exception;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;

class ChangePasswordUseCase
{
    public function __construct(
        protected UserRepositoryInterface $userRepository,
    ) {}

    public function handle(string $email, string $oldPassword, string $password): string
    {
        $user = $this->userRepository->findUserByEmail(
            $email
        );

        if (Hash::check($oldPassword, $user->getPassword())) {
            $user->setPassword($password);
            $user->setUpdatedAt(new DateTimeImmutable);
            $this->userRepository->update($user->getUserId(), $user);

            return 'Your password has been updated!';
        }

        throw new Exception("Password doesn't match", Response::HTTP_BAD_REQUEST);
    }
}
