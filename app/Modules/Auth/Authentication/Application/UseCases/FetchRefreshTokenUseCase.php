<?php

namespace App\Modules\Auth\Authentication\Application\UseCases;

use App\Modules\Auth\Authentication\Application\Services\JwtAccessTokenService;
use App\Modules\Auth\Authentication\Application\Services\JwtRefreshTokenService;
use App\Modules\Auth\Authentication\Domain\Interfaces\UserRepositoryInterface;

class FetchRefreshTokenUseCase
{
    public function __construct(
        protected JwtAccessTokenService $accessTokenService,
        protected JwtRefreshTokenService $jwtRefreshTokenService,
        protected UserRepositoryInterface $userRepository
    ) {}

    public function handle(string $userId, string $deviceName, string $deviceIP): ?array
    {
        $user = $this->userRepository->findById(
            $userId
        );

        $access_token = $this->accessTokenService->generateToken($user);
        $refresh_token = $this->jwtRefreshTokenService->generateToken($user, $deviceName, $deviceIP);

        return ['access_token' => $access_token, 'refresh_token' => $refresh_token];
    }
}
