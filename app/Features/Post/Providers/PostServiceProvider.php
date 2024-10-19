<?php

namespace App\Features\Post\Providers;

use App\Core\Bus\IQueryBus;
use App\Core\Bus\ICommandBus;
use Illuminate\Support\ServiceProvider;
use App\Features\Post\Interfaces\PostRepositoryInterface;
use App\Features\Post\Repositories\PostRepositoryInterfaceImpl;
use App\Features\Auth\Authentication\Services\JwtAccessTokenService;
use App\Features\Auth\Authentication\Services\JwtRefreshTokenService;
use App\Features\Post\UseCases\Commands\CreatePost\CreatePostCommand;
use App\Features\Post\UseCases\Queries\GetUserPosts\GetUserPostsQuery;
use App\Features\Post\UseCases\Commands\CreatePost\CreatePostCommandHandler;
use App\Features\Post\UseCases\Commands\RemovePost\RemovePostCommand;
use App\Features\Post\UseCases\Commands\RemovePost\RemovePostCommandHandler;
use App\Features\Post\UseCases\Commands\UpdatePost\UpdatePostCommand;
use App\Features\Post\UseCases\Commands\UpdatePost\UpdatePostCommandHandler;
use App\Features\Post\UseCases\Queries\GetUserPosts\GetUserPostsQueryHandler;
use App\Features\Post\UseCases\Commands\UpdatePostPrivacy\UpdatePostPrivacyCommand;
use App\Features\Post\UseCases\Commands\UpdatePostPrivacy\UpdatePostPrivacyCommandHandler;

class PostServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $singletons = [
            PostRepositoryInterface::class => PostRepositoryInterfaceImpl::class,
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
            CreatePostCommand::class => CreatePostCommandHandler::class,
            GetUserPostsQuery::class => GetUserPostsQueryHandler::class,
            UpdatePostPrivacyCommand::class => UpdatePostPrivacyCommandHandler::class,
            UpdatePostCommand::class => UpdatePostCommandHandler::class,
            RemovePostCommand::class => RemovePostCommandHandler::class,
        ]);

        $queryBus = app(IQueryBus::class);
        $queryBus->register([

        ]);

        $queryBus->register([

        ]);
    }
}