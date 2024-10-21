<?php

namespace App\Modules\Auth\Device\Providers;

use Illuminate\Support\ServiceProvider;
use App\Modules\Auth\Device\Repositories\DeviceRepositoryImpl;
use App\Modules\Auth\Device\Interfaces\DeviceRepositoryInterface;

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
