<?php

namespace App\Modules\Follow;

use App\Modules\Follow\Application\UseCases\FollowAUserUseCase;
use App\Modules\Follow\Application\UseCases\GetFollowersUseCase;
use App\Modules\Follow\Application\UseCases\GetFollowingUseCase;
use App\Modules\Follow\Application\UseCases\UnFollowAUserUseCase;
use App\Modules\Follow\Domain\Repositories\FollowRepositoryInterface;
use App\Modules\Follow\Infrastructure\Repositories\FollowRepository;
use Illuminate\Support\ServiceProvider;

class FollowServiceProvider extends ServiceProvider
{
    public function boot(): void {}

    public function register(): void
    {
        $singletons = [
            FollowAUserUseCase::class => FollowAUserUseCase::class,
            GetFollowersUseCase::class => GetFollowersUseCase::class,
            GetFollowingUseCase::class => GetFollowingUseCase::class,
            UnFollowAUserUseCase::class => UnFollowAUserUseCase::class,

            FollowRepositoryInterface::class => FollowRepository::class,

        ];

        foreach ($singletons as $abstract => $concrete) {
            $this->app->singleton(
                $abstract,
                $concrete,
            );
        }
    }
}
