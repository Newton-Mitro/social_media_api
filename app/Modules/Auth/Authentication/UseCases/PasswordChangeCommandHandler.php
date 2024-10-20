<?php

namespace App\Modules\Auth\Authentication\UseCases;

use App\Modules\Auth\User\Interfaces\UserRepositoryInterface;
use DateTimeImmutable;
use Exception;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;

class PasswordChangeCommandHandler
{
    public function __construct(
        protected UserRepositoryInterface $repository,
    ) {}

    public function handle(string $email, string $oldPassword, string $password): string
    {
        $user = $this->repository->findUserByEmail(
            $email
        );

        if (Hash::check($oldPassword, $user->getPassword())) {
            $user->setPassword($password);
            $user->setUpdatedAt(new DateTimeImmutable);
            $this->repository->update($user->getUserId(), $user);

            return 'Your password has been updated!';
        }

        throw new Exception("Password doesn't match", Response::HTTP_BAD_REQUEST);
    }
}
