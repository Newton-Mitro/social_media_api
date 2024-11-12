<?php

namespace App\Modules\Auth\Application\UseCases;

use App\Modules\Auth\Domain\Interfaces\UserRepositoryInterface;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Response;

class ReSendEmailVerifyingOTPUseCase
{
    public function __construct(
        protected UserRepositoryInterface $repository,
        protected SendEmailVerifyingOTPUseCase $sendEmailVerifyingOTPCommandHandler
    ) {}

    public function handle(string $email): void
    {
        $user = $this->repository->findByEmail(
            $email
        );

        if (! $user) {
            throw new Exception('User not found', Response::HTTP_NOT_FOUND);
        }

        if ($user->getOtpExpiresAt() && $user->getOtpExpiresAt() > Carbon::now()) {
            throw new Exception('OTP is still valid. Please check your email.', Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $this->sendEmailVerifyingOTPCommandHandler->handle(
            email: $email,
        );
    }
}
