<?php

namespace App\Modules\Auth\Authentication\Application\UseCases;

use App\Modules\Auth\Authentication\Application\Events\UserRegistered;
use App\Modules\Auth\Authentication\Application\Services\JwtAccessTokenService;
use App\Modules\Auth\Authentication\Application\Services\JwtRefreshTokenService;
use App\Modules\Auth\User\BusinessModels\UserModel;
use App\Modules\Auth\User\Interfaces\UserRepositoryInterface;
use App\Modules\Auth\User\Mappers\UserMapper;
use Carbon\Carbon;
use ErrorException;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Str;

class RegisterUserCommandHandler
{
    public function __construct(
        protected JwtAccessTokenService $accessTokenService,
        protected JwtRefreshTokenService $refreshTokenService,
        protected UserRepositoryInterface $userRepository,
        protected SendEmailVerifyingOTPCommandHandler $sendEmailVerifyingOTPCommandHandler
    ) {}

    public function handle(string $name, string $email, string $password, string $deviceName, string $deviceIP): ?array
    {
        // Check if user already exist
        $existingUser = $this->userRepository->findUserByEmail($email);

        if ($existingUser) {
            throw new ErrorException('User already exist', Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        $userModel = new UserModel(
            userId: 0,
            name: $name,
            userName: Str::slug($name, '_'),
            email: $email,
            password: $password,
        );

        // Persist user in database
        $user = $this->userRepository->create(
            $userModel
        );

        if ($user) {
            Event::dispatch(new UserRegistered($user));
            $this->sendEmailVerifyingOTPCommandHandler->handle($email);
        }

        // Update User Last Logged in date
        $user->setLastLoggedIn(Carbon::now()->toDateTimeImmutable());
        $updatedUser = $this->userRepository->update($user->getUserId(), $user);

        $mappedUser = UserMapper::toUserResource($updatedUser);

        // Generate user token here
        $access_token = $this->accessTokenService->generateToken($updatedUser);
        $refresh_token = $this->refreshTokenService->generateToken($updatedUser, $deviceName, $deviceIP);

        return ['access_token' => $access_token, 'refresh_token' => $refresh_token, 'user' => $mappedUser];
    }
}
