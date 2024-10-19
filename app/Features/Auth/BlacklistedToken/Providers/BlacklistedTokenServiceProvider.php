<?php

namespace App\Features\Auth\BlacklistedToken\Providers;

use App\Core\Bus\ICommandBus;
use App\Core\Bus\IQueryBus;
use App\Features\Auth\BlacklistedToken\Interfaces\BlacklistedTokenRepositoryInterface;
use App\Features\Auth\BlacklistedToken\Repositories\BlacklistedTokenRepositoryImpl;
use App\Features\Auth\BlacklistedToken\UseCases\Commands\AddBlackListToken\AddTokenToBlackListCommand;
use App\Features\Auth\BlacklistedToken\UseCases\Commands\AddBlackListToken\AddTokenToBlackListCommandHandler;
use App\Features\Auth\BlacklistedToken\UseCases\Queries\BlackListTokenExist\BlacklistedTokenExistQuery;
use App\Features\Auth\BlacklistedToken\UseCases\Queries\BlackListTokenExist\BlacklistedTokenExistQueryHandler;
use Illuminate\Support\ServiceProvider;

class BlacklistedTokenServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $queryBus = app(IQueryBus::class);

        $queryBus->register([
            BlacklistedTokenExistQuery::class => BlacklistedTokenExistQueryHandler::class,
        ]);

        $commandBus = app(ICommandBus::class);

        $commandBus->register([
            AddTokenToBlackListCommand::class => AddTokenToBlackListCommandHandler::class,
        ]);

    }

    public function register(): void
    {
        $singletons = [
            BlacklistedTokenRepositoryInterface::class => BlacklistedTokenRepositoryImpl::class,
        ];

        foreach ($singletons as $abstract => $concrete) {
            $this->app->singleton(
                $abstract,
                $concrete,
            );
        }
    }
}
