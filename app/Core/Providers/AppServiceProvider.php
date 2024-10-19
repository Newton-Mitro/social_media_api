<?php

namespace App\Core\Providers;

use App\Core\Bus\ICommandBus;
use App\Core\Bus\IlluminateCommandBus;
use App\Core\Bus\IlluminateQueryBus;
use App\Core\Bus\IQueryBus;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $singletons = [
            ICommandBus::class => IlluminateCommandBus::class,
            IQueryBus::class => IlluminateQueryBus::class,
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
        //
    }
}
