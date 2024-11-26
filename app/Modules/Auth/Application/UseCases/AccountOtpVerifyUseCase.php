<?php

namespace App\Modules\Auth\Application\UseCases;

use App\Modules\Auth\Application\DTOs\AuthUserDTO;
use App\Modules\Auth\Application\Mappers\UserAggregateMapper;
use App\Modules\Auth\Application\Services\JwtAccessTokenService;
use App\Modules\Auth\Application\Services\JwtRefreshTokenService;
use App\Modules\Auth\Domain\Interfaces\UserRepositoryInterface;
use Carbon\Carbon;
use DateTimeImmutable;
use Exception;
use Illuminate\Http\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class AccountOtpVerifyUseCase
{
    public function __construct(
        protected UserRepositoryInterface $userRepository,
        protected JwtAccessTokenService $accessTokenService,
        protected JwtRefreshTokenService $refreshTokenService,
    ) {}

    public function handle(string $deviceName, string $deviceIP, string $email, string $otp): AuthUserDTO
    {
        $user = $this->userRepository->findByEmail(
            $email
        );

        if (! $user) {
            throw new NotFoundHttpException("User is not registered with this email $email.", null, Response::HTTP_NOT_FOUND);
        }

        if ($user->getEmailVerifiedAt() !== null) {
            throw new Exception('Account already verified', Response::HTTP_PRECONDITION_REQUIRED);
        }

        if ($user->getOtp() === $otp && $user->getOtpExpiresAt() > Carbon::now()) {
            $user->setOtp(null);
            $user->setOtpExpiresAt(null);
            $user->setEmailVerifiedAt(new DateTimeImmutable);
            $user->setOtpVerified(true);
            $this->userRepository->save($user);

            $mappedUserDTO = UserAggregateMapper::toDTO($user);

            // Generate user token here
            $access_token = $this->accessTokenService->generateToken($mappedUserDTO);
            $refresh_token = $this->refreshTokenService->generateToken($mappedUserDTO, $deviceName, $deviceIP);

            $authUser = new AuthUserDTO(user: $mappedUserDTO, access_token: $access_token, refresh_token: $refresh_token);
            return $authUser;
        }
        throw new Exception('OTP expired or invalid', Response::HTTP_BAD_REQUEST);
    }
}
