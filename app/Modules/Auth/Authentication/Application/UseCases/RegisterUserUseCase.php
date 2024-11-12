<?php

namespace App\Modules\Auth\Authentication\Application\UseCases;

use App\Modules\Auth\Authentication\Application\Events\UserRegistered;
use App\Modules\Auth\Authentication\Application\Mappers\UserResourceMapper;
use App\Modules\Auth\Authentication\Application\Resources\AuthUserResource;
use App\Modules\Auth\Authentication\Application\Services\JwtAccessTokenService;
use App\Modules\Auth\Authentication\Application\Services\JwtRefreshTokenService;
use App\Modules\Auth\Authentication\Domain\Entities\UserEntity;
use App\Modules\Auth\Authentication\Domain\Interfaces\UserRepositoryInterface;
use Carbon\Carbon;
use ErrorException;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Str;

class RegisterUserUseCase
{
    public function __construct(
        protected JwtAccessTokenService $accessTokenService,
        protected JwtRefreshTokenService $refreshTokenService,
        protected UserRepositoryInterface $userRepository,
        protected SendEmailVerifyingOTPUseCase $sendEmailVerifyingOTPUseCase
    ) {}

    public function handle(string $name, string $email, string $password, string $deviceName, string $deviceIP): AuthUserResource
    {
        // Check if user already exist
        $existingUser = $this->userRepository->findByEmail($email);

        if ($existingUser) {
            throw new ErrorException('User already exist', Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        $userModel = new UserEntity(
            id: 0,
            name: $name,
            userName: Str::slug($name, '_'),
            email: $email,
            password: $password,
        );

        // Persist user in database
        $this->userRepository->save(
            $userModel
        );

        $createdUser = $this->userRepository->findByEmail($email);

        if ($createdUser) {
            Event::dispatch(new UserRegistered($createdUser));
            $this->sendEmailVerifyingOTPUseCase->handle($email);
        }

        // Update User Last Logged in date
        $createdUser->setLastLoggedIn(Carbon::now()->toDateTimeImmutable());
        $this->userRepository->save($createdUser);

        $mappedUser = UserResourceMapper::toResource($createdUser);

        // Generate user token here
        $access_token = $this->accessTokenService->generateToken($mappedUser);
        $refresh_token = $this->refreshTokenService->generateToken($mappedUser, $deviceName, $deviceIP);

        $authUser = new AuthUserResource(user: $mappedUser, access_token: $access_token, refresh_token: $refresh_token);
        return $authUser;
    }
}
