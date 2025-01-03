<?php

namespace App\Modules\Auth\Application\UseCases;

use App\Modules\Auth\Application\Mappers\UserAggregateMapper;
use App\Modules\Auth\Application\DTOs\AuthUserDTO;
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

    public function handle(string $userId, string $deviceName, string $deviceIP): AuthUserDTO
    {
        $user = $this->userRepository->findById(
            $userId
        );

        $userDTO = UserAggregateMapper::toDTO($user);

        $access_token = $this->accessTokenService->generateToken($userDTO);
        $refresh_token = $this->jwtRefreshTokenService->generateToken($userDTO, $deviceName, $deviceIP);

        $authUser = new AuthUserDTO(user: $userDTO, access_token: $access_token, refresh_token: $refresh_token);
        return $authUser;
    }
}
