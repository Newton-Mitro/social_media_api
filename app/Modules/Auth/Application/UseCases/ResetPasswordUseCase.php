<?php

namespace App\Modules\Auth\Application\UseCases;

use App\Modules\Auth\Domain\Interfaces\UserOTPRepositoryInterface;
use App\Modules\Auth\Domain\Interfaces\RepositoryInterface;
use DateTimeImmutable;
use Exception;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\Response;

class ResetPasswordUseCase
{
    public function __construct(
        protected RepositoryInterface $userRepository,
        protected UserOTPRepositoryInterface $userOTPRepository
    ) {}

    public function handle(string $email, string $password, string $token): void
    {
        // if user email don't exists, through exception
        // if user email exists, reset password
        $user = $this->userRepository->findByEmail(
            $email
        );
        if ($user === null) {
            throw new Exception('Email is not valid', Response::HTTP_NOT_FOUND);
        }
        $userOTP = $this->userOTPRepository->findUserOTPByUserId(
            $user->getId()
        );
        // if token matched then reset the password
        if ($userOTP->getToken() === $token) {
            $user->setPassword(Hash::make($password));
            $user->setUpdatedAt(new DateTimeImmutable);
            $this->userRepository->save($user);
        } else {
            throw new Exception('Bad request', Response::HTTP_BAD_REQUEST);
        }
    }
}
