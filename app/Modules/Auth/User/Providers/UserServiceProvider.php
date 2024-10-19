<?php

namespace App\Modules\Auth\User\Providers;

use App\Modules\Auth\Authentication\Services\JwtAccessTokenService;
use App\Modules\Auth\Authentication\Services\JwtRefreshTokenService;
use App\Modules\Auth\User\Interfaces\UserRepositoryInterface;
use App\Modules\Auth\User\Repositories\UserRepositoryInterfaceImpl;
use App\Modules\Auth\User\UseCases\Commands\CreateUser\CreateUserCommandHandler;
use App\Modules\Auth\User\UseCases\Commands\UpdateUser\UpdateCoverPictureCommandHandler;
use App\Modules\Auth\User\UseCases\Commands\UpdateUser\UpdateProfilePictureCommandHandler;
use App\Modules\Auth\User\UseCases\Queries\FindUser\FindUserQueryHandler;
use App\Modules\Auth\User\UseCases\Queries\FindUserByEmail\FindUserByEmailQueryHandler;
use Illuminate\Support\ServiceProvider;

class UserServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $singletons = [
            UserRepositoryInterface::class => UserRepositoryInterfaceImpl::class,
            JwtAccessTokenService::class => JwtAccessTokenService::class,
            JwtRefreshTokenService::class => JwtRefreshTokenService::class,

            CreateUserCommandHandler::class => CreateUserCommandHandler::class,
            UpdateCoverPictureCommandHandler::class => UpdateCoverPictureCommandHandler::class,
            UpdateProfilePictureCommandHandler::class => UpdateProfilePictureCommandHandler::class,

            FindUserQueryHandler::class => FindUserQueryHandler::class,
            FindUserByEmailQueryHandler::class => FindUserByEmailQueryHandler::class,
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
