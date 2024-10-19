<?php

namespace App\Features\Auth\User\Providers;

use App\Core\Bus\ICommandBus;
use App\Core\Bus\IQueryBus;
use App\Features\Auth\Authentication\Services\JwtAccessTokenService;
use App\Features\Auth\Authentication\Services\JwtRefreshTokenService;
use App\Features\Auth\User\Interfaces\UserRepositoryInterface;
use App\Features\Auth\User\Repositories\UserRepositoryInterfaceImpl;
use App\Features\Auth\User\UseCases\Commands\CreateUser\CreateUserCommand;
use App\Features\Auth\User\UseCases\Commands\CreateUser\CreateUserCommandHandler;
use App\Features\Auth\User\UseCases\Commands\UpdateUser\UpdateCoverPictureCommand;
use App\Features\Auth\User\UseCases\Commands\UpdateUser\UpdateCoverPictureCommandHandler;
use App\Features\Auth\User\UseCases\Commands\UpdateUser\UpdateProfilePictureCommand;
use App\Features\Auth\User\UseCases\Commands\UpdateUser\UpdateProfilePictureCommandHandler;
use App\Features\Auth\User\UseCases\Queries\FindUser\FindUserQuery;
use App\Features\Auth\User\UseCases\Queries\FindUser\FindUserQueryHandler;
use App\Features\Auth\User\UseCases\Queries\FindUserByEmail\FindUserByEmailQuery;
use App\Features\Auth\User\UseCases\Queries\FindUserByEmail\FindUserByEmailQueryHandler;
use Illuminate\Support\ServiceProvider;

class UserServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $singletons = [
            UserRepositoryInterface::class => UserRepositoryInterfaceImpl::class,
            JwtAccessTokenService::class => JwtAccessTokenService::class,
            JwtRefreshTokenService::class => JwtRefreshTokenService::class,
        ];

        foreach ($singletons as $abstract => $concrete) {
            $this->app->singleton(
                $abstract,
                $concrete,
            );
        }
    }

    public function boot(): void
    {
        $commandBus = app(ICommandBus::class);

        $commandBus->register([
            CreateUserCommand::class => CreateUserCommandHandler::class,
            UpdateCoverPictureCommand::class => UpdateCoverPictureCommandHandler::class,
            UpdateProfilePictureCommand::class => UpdateProfilePictureCommandHandler::class,
        ]);

        $queryBus = app(IQueryBus::class);

        $queryBus->register([
            FindUserQuery::class => FindUserQueryHandler::class,
            FindUserByEmailQuery::class => FindUserByEmailQueryHandler::class,
        ]);
    }
}
