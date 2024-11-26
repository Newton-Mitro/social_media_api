<?php

namespace App\Modules\Auth\Application\UseCases;

use App\Core\Enums\OtpTypes;
use App\Modules\Auth\Domain\Interfaces\UserOTPRepositoryInterface;
use App\Modules\Auth\Domain\Interfaces\UserRepositoryInterface;
use DateTimeImmutable;
use Exception;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ResetPasswordUseCase
{
    public function __construct(
        protected UserRepositoryInterface $userRepository,
        protected UserOTPRepositoryInterface $userOTPRepository
    ) {}

    public function handle(string $email, string $password, string $token): void
    {
        $user = $this->userRepository->findByEmail(
            $email
        );
        if (!$user) {
            throw new NotFoundHttpException("User is not registered with this email $email.", null, Response::HTTP_NOT_FOUND);
        }
        $userOTP = $this->userOTPRepository->findUserOTPByUserIdAndType(
            $user->getId(),
            OtpTypes::FORGOT_PASSWORD
        );
        // if token matched then reset the password
        if ($userOTP->getToken() === $token) {
            $user->setPassword(Hash::make($password));
            $user->setUpdatedAt(new DateTimeImmutable);
            $this->userRepository->save($user);
        } else {
            throw new Exception('Invalid token', Response::HTTP_PRECONDITION_FAILED);
        }
    }
}
