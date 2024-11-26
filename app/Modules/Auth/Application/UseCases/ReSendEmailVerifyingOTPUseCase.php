<?php

namespace App\Modules\Auth\Application\UseCases;

use App\Core\Enums\OtpTypes;
use App\Modules\Auth\Domain\Interfaces\UserOTPRepositoryInterface;
use App\Modules\Auth\Domain\Interfaces\UserRepositoryInterface;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ReSendEmailVerifyingOTPUseCase
{
    public function __construct(
        protected UserOTPRepositoryInterface $userOTPRepository,
        protected UserRepositoryInterface $userRepository,
    ) {}

    public function handle(string $email): void
    {
        $user = $this->userRepository->findByEmail(
            $email
        );

        if (! $user) {
            throw new NotFoundHttpException("User is not registered with this email $email.", null, Response::HTTP_NOT_FOUND);
        }

        $userOtp = $this->userOTPRepository->findUserOTPByUserIdAndType(
            $user->getId(),
            OtpTypes::USER_REGISTERED
        );

        if ($userOtp->getExpiresAt() && $userOtp->getExpiresAt() > Carbon::now()) {
            throw new Exception('OTP is still valid. Please check your email.', Response::HTTP_PRECONDITION_FAILED);
        }

        // Generate OTP

        // Store in db

        // Send Email OTP
    }
}
