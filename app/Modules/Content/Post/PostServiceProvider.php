<?php

namespace App\Modules\Content\Post;

use App\Modules\Content\Post\Domain\Repositories\PostRepositoryInterface;
use App\Modules\Content\Post\Infrastructure\Repositories\PostRepository;
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
