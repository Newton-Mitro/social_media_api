<?php

namespace App\Modules\Auth\Application\UseCases;

use App\Modules\Auth\Application\Mappers\UserResourceMapper;
use App\Modules\Auth\Application\Resources\AuthUserResource;
use App\Modules\Auth\Application\Services\JwtAccessTokenService;
use App\Modules\Auth\Application\Services\JwtRefreshTokenService;
use App\Modules\Auth\Domain\Interfaces\UserRepositoryInterface;
use Carbon\Carbon;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\UnauthorizedException;

class UserLoginUseCase
{
    public function __construct(
        protected JwtAccessTokenService $accessTokenService,
        protected JwtRefreshTokenService $refreshTokenService,
        protected UserRepositoryInterface $userRepository
    ) {}

    public function handle(string $email, string $password, string $deviceName, string $deviceIP): AuthUserResource
    {
        if (Auth::attempt(['email' => $email, 'password' => $password])) {

            $user = $this->userRepository->findByEmail($email);

            // Update User Last Logged in date
            $user->setLastLoggedIn(Carbon::now()->toDateTimeImmutable());
            $this->userRepository->save($user);

            $mappedUser = UserResourceMapper::toResource($user);

            // Generate user token here
            $access_token = $this->accessTokenService->generateToken($mappedUser);
            $refresh_token = $this->refreshTokenService->generateToken($mappedUser, $deviceName, $deviceIP);

            $authUser = new AuthUserResource(user: $mappedUser, access_token: $access_token, refresh_token: $refresh_token);
            return $authUser;
        }

        throw new UnauthorizedException('Invalid email or password.', Response::HTTP_UNAUTHORIZED);
    }
}
