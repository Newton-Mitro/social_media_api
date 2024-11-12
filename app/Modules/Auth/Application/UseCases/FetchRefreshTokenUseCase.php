<?php

namespace App\Modules\Auth\Application\UseCases;

use App\Modules\Auth\Application\Mappers\UserResourceMapper;
use App\Modules\Auth\Application\Resources\AuthUserResource;
use App\Modules\Auth\Application\Services\JwtAccessTokenService;
use App\Modules\Auth\Application\Services\JwtRefreshTokenService;
use App\Modules\Auth\Domain\Interfaces\UserRepositoryInterface;

class FetchRefreshTokenUseCase
{
    public function __construct(
        protected JwtAccessTokenService $accessTokenService,
        protected JwtRefreshTokenService $jwtRefreshTokenService,
        protected UserRepositoryInterface $userRepository
    ) {}

    public function handle(string $userId, string $deviceName, string $deviceIP): AuthUserResource
    {
        $user = $this->userRepository->findById(
            $userId
        );

        $userResource = UserResourceMapper::toResource($user);

        $access_token = $this->accessTokenService->generateToken($userResource);
        $refresh_token = $this->jwtRefreshTokenService->generateToken($userResource, $deviceName, $deviceIP);

        $authUser = new AuthUserResource(user: $userResource, access_token: $access_token, refresh_token: $refresh_token);
        return $authUser;
    }
}
