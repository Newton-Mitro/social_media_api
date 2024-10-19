<?php

namespace App\Features\Auth\Authentication\UseCases\Commands\Login;

use App\Features\Auth\Authentication\Services\JwtAccessTokenService;
use App\Features\Auth\Authentication\Services\JwtRefreshTokenService;
use App\Features\Auth\User\Interfaces\UserRepositoryInterface;
use App\Features\Auth\User\Mappers\UserMapper;
use App\Features\Auth\User\UseCases\Queries\FindUserByEmail\FindUserByEmailQuery;
use Carbon\Carbon;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\UnauthorizedException;

class LoginCommandHandler
{
    public function __construct(
        protected JwtAccessTokenService $accessTokenService,
        protected JwtRefreshTokenService $refreshTokenService,
        protected UserRepositoryInterface $repository
    ) {}

    public function handle(LoginCommand $command): ?array
    {
        if (Auth::attempt(['email' => $command->getEmail(), 'password' => $command->getPassword()])) {

            $user = $this->queryBus->ask(
                new FindUserByEmailQuery($command->getEmail())
            );

            // Update User Last Logged in date
            $user->setLastLoggedIn(Carbon::now()->toDateTimeImmutable());
            $updatedUser = $this->repository->update($user->getUserId(), $user);

            $mappedUser = UserMapper::toUserResource($updatedUser);

            // Generate user token here
            $access_token = $this->accessTokenService->generateToken($updatedUser);
            $refresh_token = $this->refreshTokenService->generateToken($updatedUser, $command->getDeviceName(), $command->getDeviceIp());

            return ['access_token' => $access_token, 'refresh_token' => $refresh_token, 'user' => $mappedUser];
        }

        throw new UnauthorizedException('Invalid email or password.', Response::HTTP_UNAUTHORIZED);
    }
}
