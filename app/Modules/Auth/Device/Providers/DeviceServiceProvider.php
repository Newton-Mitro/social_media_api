<?php

namespace App\Features\Auth\Device\Providers;

use App\Core\Bus\ICommandBus;
use App\Core\Bus\IQueryBus;
use App\Features\Auth\Device\Interfaces\DeviceRepositoryInterface;
use App\Features\Auth\Device\Repositories\DeviceRepositoryImpl;
use App\Features\Auth\Device\UseCases\Commands\CreateDevice\CreateDeviceCommand;
use App\Features\Auth\Device\UseCases\Commands\CreateDevice\CreateDeviceCommandHandler;
use App\Features\Auth\Device\UseCases\Commands\LogoutFromAllDevice\LogoutFormAllDeviceCommandHandler;
use App\Features\Auth\Device\UseCases\Commands\LogoutFromAllDevice\LogoutFromAllDevicesCommand;
use App\Features\Auth\Device\UseCases\Commands\UpdateDevice\UpdateDeviceCommand;
use App\Features\Auth\Device\UseCases\Commands\UpdateDevice\UpdateDeviceCommandHandler;
use App\Features\Auth\Device\UseCases\Queries\FindDeviceByUserIDAndDeviceName\FindDeviceByUserIDAndDeviceNameQuery;
use App\Features\Auth\Device\UseCases\Queries\FindDeviceByUserIDAndDeviceName\FindDeviceByUserIDAndDeviceNameQueryHandler;
use App\Features\Auth\Device\UseCases\Queries\FindDeviceWithToken\FindDeviceWithTokenQuery;
use App\Features\Auth\Device\UseCases\Queries\FindDeviceWithToken\FindDeviceWithTokenQueryHandler;
use App\Features\Auth\Device\UseCases\Queries\ListUserLoginDevice\ListUserLoggedInDeviceQuery;
use App\Features\Auth\Device\UseCases\Queries\ListUserLoginDevice\ListUserLoggedInDeviceQueryHandler;
use Illuminate\Support\ServiceProvider;

class DeviceServiceProvider extends ServiceProvider
{
    public function boot(): void
    {

        $queryBus = app(IQueryBus::class);

        $queryBus->register([
            ListUserLoggedInDeviceQuery::class => ListUserLoggedInDeviceQueryHandler::class,
        ]);

        $queryBus->register([
            FindDeviceByUserIDAndDeviceNameQuery::class => FindDeviceByUserIDAndDeviceNameQueryHandler::class,
        ]);

        $queryBus->register([
            FindDeviceWithTokenQuery::class => FindDeviceWithTokenQueryHandler::class,
        ]);

        $commandBus = app(ICommandBus::class);

        $commandBus->register([
            LogoutFromAllDevicesCommand::class => LogoutFormAllDeviceCommandHandler::class,
        ]);

        $commandBus->register([
            CreateDeviceCommand::class => CreateDeviceCommandHandler::class,
        ]);

        $commandBus->register([
            UpdateDeviceCommand::class => UpdateDeviceCommandHandler::class,
        ]);

    }

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
