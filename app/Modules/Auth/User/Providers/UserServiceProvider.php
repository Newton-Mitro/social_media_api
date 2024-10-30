<?php

namespace App\Modules\Auth\User\Providers;

use Illuminate\Support\ServiceProvider;
use App\Modules\Auth\User\UseCases\FetchUserProfileUseCase;
use App\Modules\Auth\User\Interfaces\UserRepositoryInterface;
use App\Modules\Auth\Authentication\Services\JwtAccessTokenService;
use App\Modules\Auth\User\Repositories\UserRepositoryInterfaceImpl;
use App\Modules\Auth\Authentication\Services\JwtRefreshTokenService;
use App\Modules\Auth\User\UseCases\UpdateCoverPictureCommandHandler;
use App\Modules\Auth\User\UseCases\UpdateProfilePictureCommandHandler;

class UserServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $singletons = [
            UserRepositoryInterface::class => UserRepositoryInterfaceImpl::class,
            JwtAccessTokenService::class => JwtAccessTokenService::class,
            JwtRefreshTokenService::class => JwtRefreshTokenService::class,

            UpdateCoverPictureCommandHandler::class => UpdateCoverPictureCommandHandler::class,
            UpdateProfilePictureCommandHandler::class => UpdateProfilePictureCommandHandler::class,
            FetchUserProfileUseCase::class => FetchUserProfileUseCase::class,
        ];

        foreach ($singletons as $abstract => $concrete) {
            $this->app->singleton(
                $abstract,
                $concrete,
            );
        }
    }

    public function boot(): void {}
}
