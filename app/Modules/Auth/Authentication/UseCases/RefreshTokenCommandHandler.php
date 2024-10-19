<?php

namespace App\Features\Auth\Authentication\UseCases\Commands\RefreshToken;

use App\Features\Auth\Authentication\Services\JwtAccessTokenService;
use App\Features\Auth\Authentication\Services\JwtRefreshTokenService;
use App\Features\Auth\User\UseCases\Queries\FindUser\FindUserQuery;

class RefreshTokenCommandHandler
{
    public function __construct(
        protected JwtAccessTokenService $accessTokenService,
        protected JwtRefreshTokenService $jwtRefreshTokenService,
    ) {}

    public function handle(RefreshTokenCommand $command): ?array
    {
        $user = $this->queryBus->ask(
            new FindUserQuery($command->getUserId())
        );

        $access_token = $this->accessTokenService->generateToken($user);
        $refresh_token = $this->jwtRefreshTokenService->generateToken($user, $command->getDeviceName(), $command->getDeviceIp());

        return ['access_token' => $access_token, 'refresh_token' => $refresh_token];
    }
}
