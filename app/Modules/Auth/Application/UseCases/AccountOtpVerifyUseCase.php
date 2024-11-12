<?php

namespace App\Modules\Auth\Application\UseCases;

use Exception;
use Carbon\Carbon;
use DateTimeImmutable;
use Illuminate\Http\Response;
use App\Modules\Auth\Application\Mappers\UserResourceMapper;
use App\Modules\Auth\Application\Resources\AuthUserResource;
use App\Modules\Auth\Domain\Interfaces\UserRepositoryInterface;
use App\Modules\Auth\Application\Services\JwtAccessTokenService;
use App\Modules\Auth\Application\Services\JwtRefreshTokenService;

class AccountOtpVerifyUseCase
{
    public function __construct(
        protected UserRepositoryInterface $userRepository,
        protected JwtAccessTokenService $accessTokenService,
        protected JwtRefreshTokenService $refreshTokenService,
    ) {}

    public function handle(string $deviceName, string $deviceIP, string $email, string $otp): AuthUserResource
    {
        $user = $this->userRepository->findByEmail(
            $email
        );

        if (! $user) {
            throw new Exception('User not found', Response::HTTP_NOT_FOUND);
        }

        if ($user->getEmailVerifiedAt() !== null) {
            throw new Exception('Account already verified', Response::HTTP_NOT_ACCEPTABLE);
        }

        if ($user->getOtp() === $otp && $user->getOtpExpiresAt() > Carbon::now()) {
            $user->setOtp(null);
            $user->setOtpExpiresAt(null);
            $user->setEmailVerifiedAt(new DateTimeImmutable);
            $user->setOtpVerified(true);
            $this->userRepository->save($user);

            $mappedUserResource = UserResourceMapper::toResource($user);

            // Generate user token here
            $access_token = $this->accessTokenService->generateToken($mappedUserResource);
            $refresh_token = $this->refreshTokenService->generateToken($mappedUserResource, $deviceName, $deviceIP);

            $authUser = new AuthUserResource(user: $mappedUserResource, access_token: $access_token, refresh_token: $refresh_token);
            return $authUser;
        }
        throw new Exception('OTP expired or invalid', Response::HTTP_FORBIDDEN);
    }
}
