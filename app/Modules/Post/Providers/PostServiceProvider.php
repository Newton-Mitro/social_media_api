<?php

namespace App\Modules\Post\Providers;

use Illuminate\Support\ServiceProvider;
use App\Modules\Post\Interfaces\PostRepositoryInterface;
use App\Modules\Post\Repositories\PostRepositoryInterfaceImpl;
use App\Modules\Auth\Authentication\Services\JwtAccessTokenService;
use App\Modules\Auth\Authentication\Services\JwtRefreshTokenService;
use App\Modules\Post\UseCases\Commands\CreatePost\CreatePostCommandHandler;
use App\Modules\Post\UseCases\Commands\RemovePost\RemovePostCommandHandler;
use App\Modules\Post\UseCases\Commands\UpdatePost\UpdatePostCommandHandler;
use App\Modules\Post\UseCases\Queries\GetUserPosts\GetUserPostsQueryHandler;
use App\Modules\Post\UseCases\Commands\UpdatePostPrivacy\UpdatePostPrivacyCommandHandler;

class PostServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $singletons = [
            PostRepositoryInterface::class => PostRepositoryInterfaceImpl::class,
            JwtAccessTokenService::class => JwtAccessTokenService::class,
            JwtRefreshTokenService::class => JwtRefreshTokenService::class,

            CreatePostCommandHandler::class => CreatePostCommandHandler::class,
            GetUserPostsQueryHandler::class => GetUserPostsQueryHandler::class,
            UpdatePostPrivacyCommandHandler::class => UpdatePostPrivacyCommandHandler::class,
            UpdatePostCommandHandler::class => UpdatePostCommandHandler::class,
            RemovePostCommandHandler::class => RemovePostCommandHandler::class,
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
