<?php
namespace App\Features\Auth\Privacy\Providers;

use App\Core\Bus\IQueryBus;
use App\Core\Bus\ICommandBus;
use Carbon\Laravel\ServiceProvider;
use App\Features\Auth\Privacy\UseCases\Queries\GetPrivacyQuery;
use App\Features\Auth\Privacy\Interfaces\PrivacyRepositoryInterface;
use App\Features\Auth\Privacy\UseCases\Queries\GetPrivacyQueryHandler;
use App\Features\Auth\Privacy\Repositories\PrivacyRepositoryInterfaceImpl;

class PrivacyServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        // Register command mappings
        $commandBus = app(ICommandBus::class);

        $commandBus->register([
        ]);

        $queryBus = app(IQueryBus::class);

        $queryBus->register([
            GetPrivacyQuery::class => GetPrivacyQueryHandler::class,
        ]);
    }

    public function register(): void
    {
        $singletons = [
            PrivacyRepositoryInterface::class => PrivacyRepositoryInterfaceImpl::class,
        ];

        foreach ($singletons as $abstract => $concrete) {
            $this->app->singleton(
                $abstract,
                $concrete,
            );
        }
    }
}