<?php

namespace App\Modules\Auth\Authentication\Application\UseCases;

use App\Modules\Auth\Authentication\Domain\Interfaces\UserRepositoryInterface;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Response;

class ReSendEmailVerifyingOTPCommandHandler
{
    public function __construct(
        protected UserRepositoryInterface $repository,
        protected SendEmailVerifyingOTPCommandHandler $sendEmailVerifyingOTPCommandHandler
    ) {}

    public function handle(string $email): void
    {
        $user = $this->repository->findUserByEmail(
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
