<?php

namespace App\Modules\Auth\Authentication\UseCases\Commands\VerifyEmailVerifyingOTP;

use App\Modules\Auth\Authentication\Services\JwtAccessTokenService;
use App\Modules\Auth\Authentication\Services\JwtRefreshTokenService;
use App\Modules\Auth\User\Interfaces\UserRepositoryInterface;
use App\Modules\Auth\User\Mappers\UserMapper;
use App\Modules\Auth\User\UseCases\Queries\FindUserByEmail\FindUserByEmailQuery;
use Carbon\Carbon;
use DateTimeImmutable;
use Exception;
use Illuminate\Http\Response;

class VerifyEmailVerifyingOTPCommandHandler
{
    public function __construct(
        protected UserRepositoryInterface $repository,
        protected JwtAccessTokenService $accessTokenService,
        protected JwtRefreshTokenService $refreshTokenService,
    ) {}

    public function handle(VerifyEmailVerifyingOTPCommand $command): array
    {
        $user = $this->queryBus->ask(
            new FindUserByEmailQuery($command->getEmail())
        );

        if (! $user) {
            throw new Exception('User not found', Response::HTTP_NOT_FOUND);
        }

        // TODO: Implement UpdateUserCommand
        if ($user->getOtp() === $command->getOtp() && $user->getOtpExpiresAt() > Carbon::now()) {
            $user->setOtp(null);
            $user->setOtpExpiresAt(null);
            $user->setEmailVerifiedAt(new DateTimeImmutable);
            $user->setOtpVerified(true);
            $updatedUserModel = $this->repository->update($user->getUserId(), $user);

            // Generate user token here
            $access_token = $this->accessTokenService->generateToken($updatedUserModel);
            $refresh_token = $this->refreshTokenService->generateToken($updatedUserModel, $command->getDeviceName(), $command->getDeviceIp());

            return ['access_token' => $access_token, 'refresh_token' => $refresh_token, 'user' => UserMapper::toUserResource($updatedUserModel)];
        }
        throw new Exception('OTP expired or invalid', Response::HTTP_FORBIDDEN);
    }
}
