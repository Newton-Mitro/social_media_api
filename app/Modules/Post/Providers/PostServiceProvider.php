<?php

namespace App\Modules\Post\Providers;

use App\Modules\Post\Core\Interfaces\PostRepositoryInterface;
use App\Modules\Post\Infrastructure\Repositories\PostRepository;
use Illuminate\Support\ServiceProvider;


class PostServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $singletons = [
            PostRepositoryInterface::class => PostRepository::class,
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
