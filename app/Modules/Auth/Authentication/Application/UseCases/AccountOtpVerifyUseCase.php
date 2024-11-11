<?php

namespace App\Modules\Auth\Authentication\Application\UseCases;

use App\Modules\Auth\Authentication\Application\Services\JwtAccessTokenService;
use App\Modules\Auth\Authentication\Application\Services\JwtRefreshTokenService;
use App\Modules\Auth\Authentication\Domain\Interfaces\UserRepositoryInterface;
use App\Modules\Auth\Authentication\Infrastructure\Mappers\UserResourceMapper;
use Carbon\Carbon;
use DateTimeImmutable;
use Exception;
use Illuminate\Http\Response;

class AccountOtpVerifyUseCase
{
    public function __construct(
        protected UserRepositoryInterface $userRepository,
        protected JwtAccessTokenService $accessTokenService,
        protected JwtRefreshTokenService $refreshTokenService,
    ) {}

    public function handle(string $deviceName, string $deviceIP, string $email, string $otp): array
    {
        $user = $this->userRepository->findUserByEmail(
            $email
        );

        if (! $user) {
            throw new Exception('User not found', Response::HTTP_NOT_FOUND);
        }

        // TODO: Implement UpdateUserCommand
        if ($user->getOtp() === $otp && $user->getOtpExpiresAt() > Carbon::now()) {
            $user->setOtp(null);
            $user->setOtpExpiresAt(null);
            $user->setEmailVerifiedAt(new DateTimeImmutable);
            $user->setOtpVerified(true);
            $updatedUserModel = $this->userRepository->update($user->getUserId(), $user);

            // Generate user token here
            $access_token = $this->accessTokenService->generateToken($updatedUserModel);
            $refresh_token = $this->refreshTokenService->generateToken($updatedUserModel, $deviceName, $deviceIP);

            return ['access_token' => $access_token, 'refresh_token' => $refresh_token, 'user' => UserResourceMapper::toUserResource($updatedUserModel)];
        }
        throw new Exception('OTP expired or invalid', Response::HTTP_FORBIDDEN);
    }
}
