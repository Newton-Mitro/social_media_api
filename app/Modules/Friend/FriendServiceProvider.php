<?php

namespace App\Modules\Friend;

use App\Modules\Friend\Application\UseCases\AcceptFriendRequestUseCase;
use App\Modules\Friend\Application\UseCases\GetFriendsListUseCase;
use App\Modules\Friend\Application\UseCases\RejectFriendRequestUseCase;
use App\Modules\Friend\Application\UseCases\SendFriendRequestUseCase;
use App\Modules\Friend\Domain\Repositories\FriendRepositoryInterface;
use App\Modules\Friend\Infrastructure\Repositories\FriendRepository;
use Illuminate\Support\ServiceProvider;

class FriendServiceProvider extends ServiceProvider
{
    public function boot(): void {}

    public function register(): void
    {
        $singletons = [
            AcceptFriendRequestUseCase::class => AcceptFriendRequestUseCase::class,
            GetFriendsListUseCase::class => GetFriendsListUseCase::class,
            RejectFriendRequestUseCase::class => RejectFriendRequestUseCase::class,
            SendFriendRequestUseCase::class => SendFriendRequestUseCase::class,

            FriendRepositoryInterface::class => FriendRepository::class,
        ];

        foreach ($singletons as $abstract => $concrete) {
            $this->app->singleton(
                $abstract,
                $concrete,
            );
        }
    }
}
