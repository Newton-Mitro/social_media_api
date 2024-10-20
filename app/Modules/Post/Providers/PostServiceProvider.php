<?php

namespace App\Modules\Post\Providers;

use Illuminate\Support\ServiceProvider;
use App\Modules\Post\Core\Interfaces\PostRepositoryInterface;
use App\Modules\Post\Infrastructure\Repositories\PostRepositoryInterfaceImpl;


class PostServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $singletons = [
            PostRepositoryInterface::class => PostRepositoryInterfaceImpl::class,
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
