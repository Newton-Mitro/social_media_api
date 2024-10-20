<?php

namespace App\Modules\Auth\BlacklistedToken\Providers;

use App\Modules\Auth\BlacklistedToken\Interfaces\BlacklistedTokenRepositoryInterface;
use App\Modules\Auth\BlacklistedToken\Repositories\BlacklistedTokenRepositoryImpl;
use App\Modules\Auth\BlacklistedToken\UseCases\Commands\AddBlackListToken\AddTokenToBlackListCommandHandler;
use App\Modules\Auth\BlacklistedToken\UseCases\Queries\BlackListTokenExist\BlacklistedTokenExistQueryHandler;
use Illuminate\Support\ServiceProvider;

class BlacklistedTokenServiceProvider extends ServiceProvider
{
    public function boot(): void {}

    public function register(): void
    {
        $singletons = [
            BlacklistedTokenRepositoryInterface::class => BlacklistedTokenRepositoryImpl::class,
            BlacklistedTokenExistQueryHandler::class => BlacklistedTokenExistQueryHandler::class,
            AddTokenToBlackListCommandHandler::class => AddTokenToBlackListCommandHandler::class,
        ];

        foreach ($singletons as $abstract => $concrete) {
            $this->app->singleton(
                $abstract,
                $concrete,
            );
        }
    }
}
