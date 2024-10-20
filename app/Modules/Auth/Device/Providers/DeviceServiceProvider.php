<?php

namespace App\Modules\Auth\Device\Providers;

use App\Modules\Auth\Device\Interfaces\DeviceRepositoryInterface;
use App\Modules\Auth\Device\Repositories\DeviceRepositoryImpl;
use Illuminate\Support\ServiceProvider;

class DeviceServiceProvider extends ServiceProvider
{
    public function boot(): void {}

    public function register(): void
    {
        $singletons = [
            DeviceRepositoryInterface::class => DeviceRepositoryImpl::class,
        ];

        foreach ($singletons as $abstract => $concrete) {
            $this->app->singleton(
                $abstract,
                $concrete,
            );
        }
    }
}
