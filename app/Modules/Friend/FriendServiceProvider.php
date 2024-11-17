<?php

namespace App\Modules\Friend;

use App\Modules\Auth\Application\Events\UserRegistered;
use App\Modules\Auth\Application\Listeners\UserRegisteredEventHandler;
use App\Modules\Auth\Application\UseCases\UserLoginUseCase;
use App\Modules\Auth\Domain\Interfaces\BlacklistedTokenRepositoryInterface;
use App\Modules\Auth\Infrastructure\Repositories\BlacklistedTokenRepository;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\ServiceProvider;


class FriendServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        // Register event mappings
        Event::listen(
            UserRegistered::class,
            [UserRegisteredEventHandler::class, 'handle']
        );
    }

    public function register(): void
    {
        $singletons = [
            UserLoginUseCase::class => UserLoginUseCase::class,

            BlacklistedTokenRepositoryInterface::class => BlacklistedTokenRepository::class,

        ];

        foreach ($singletons as $abstract => $concrete) {
            $this->app->singleton(
                $abstract,
                $concrete,
            );
        }
    }
}
