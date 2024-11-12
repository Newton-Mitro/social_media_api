<?php

namespace App\Modules\Auth\Authentication\Application\UseCases;

use App\Modules\Auth\Authentication\Application\Mappers\UserResourceMapper;
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

        $userResource = UserResourceMapper::toResource($user);

        $access_token = $this->accessTokenService->generateToken($userResource);
        $refresh_token = $this->jwtRefreshTokenService->generateToken($userResource, $deviceName, $deviceIP);

        return ['user' => $userResource, 'access_token' => $access_token, 'refresh_token' => $refresh_token];
    }
}
