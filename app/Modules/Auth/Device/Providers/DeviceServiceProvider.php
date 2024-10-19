<?php

namespace App\Modules\Auth\Device\Providers;

use App\Modules\Auth\Device\Interfaces\DeviceRepositoryInterface;
use App\Modules\Auth\Device\Repositories\DeviceRepositoryImpl;
use App\Modules\Auth\Device\UseCases\Commands\CreateDevice\CreateDeviceCommandHandler;
use App\Modules\Auth\Device\UseCases\Commands\LogoutFromAllDevice\LogoutFormAllDeviceCommandHandler;
use App\Modules\Auth\Device\UseCases\Commands\UpdateDevice\UpdateDeviceCommandHandler;
use App\Modules\Auth\Device\UseCases\Queries\FindDeviceByUserIDAndDeviceName\FindDeviceByUserIDAndDeviceNameQueryHandler;
use App\Modules\Auth\Device\UseCases\Queries\FindDeviceWithToken\FindDeviceWithTokenQueryHandler;
use App\Modules\Auth\Device\UseCases\Queries\ListUserLoginDevice\ListUserLoggedInDeviceQueryHandler;
use Illuminate\Support\ServiceProvider;

class DeviceServiceProvider extends ServiceProvider
{
    public function boot(): void {}

    public function register(): void
    {
        $singletons = [
            DeviceRepositoryInterface::class => DeviceRepositoryImpl::class,

            ListUserLoggedInDeviceQueryHandler::class => ListUserLoggedInDeviceQueryHandler::class,
            FindDeviceByUserIDAndDeviceNameQueryHandler::class => FindDeviceByUserIDAndDeviceNameQueryHandler::class,
            FindDeviceWithTokenQueryHandler::class => FindDeviceWithTokenQueryHandler::class,

            LogoutFormAllDeviceCommandHandler::class => LogoutFormAllDeviceCommandHandler::class,
            CreateDeviceCommandHandler::class => CreateDeviceCommandHandler::class,
            UpdateDeviceCommandHandler::class => UpdateDeviceCommandHandler::class,
        ];

        foreach ($singletons as $abstract => $concrete) {
            $this->app->singleton(
                $abstract,
                $concrete,
            );
        }
    }
}
