<?php

namespace App\Modules\Auth\Authentication\UseCases;

use Carbon\Carbon;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use App\Modules\Auth\User\Mappers\UserMapper;
use Illuminate\Validation\UnauthorizedException;
use App\Modules\Auth\User\Interfaces\UserRepositoryInterface;
use App\Modules\Auth\Authentication\Services\JwtAccessTokenService;
use App\Modules\Auth\Authentication\Services\JwtRefreshTokenService;

class LoginCommandHandler
{
    public function __construct(
        protected JwtAccessTokenService $accessTokenService,
        protected JwtRefreshTokenService $refreshTokenService,
        protected UserRepositoryInterface $userRepository
    ) {}

    public function handle(string $email, string $password, string $deviceName, string $deviceIP): ?array
    {
        if (Auth::attempt(['email' => $email, 'password' => $password])) {

            $user = $this->userRepository->findUserByEmail($email);

            // Update User Last Logged in date
            $user->setLastLoggedIn(Carbon::now()->toDateTimeImmutable());
            $updatedUser = $this->userRepository->update($user->getUserId(), $user);

            $mappedUser = UserMapper::toUserResource($updatedUser);

            // Generate user token here
            $access_token = $this->accessTokenService->generateToken($updatedUser);
            $refresh_token = $this->refreshTokenService->generateToken($updatedUser, $deviceName, $deviceIP);

            return ['access_token' => $access_token, 'refresh_token' => $refresh_token, 'user' => $mappedUser];
        }

        throw new UnauthorizedException('Invalid email or password.', Response::HTTP_UNAUTHORIZED);
    }
}
