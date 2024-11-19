<?php

namespace App\Modules\Content\Privacy;

use Illuminate\Support\ServiceProvider;
use App\Modules\Content\Privacy\Infrastructure\Repositories\PrivacyRepository;
use App\Modules\Content\Privacy\Domain\Repositories\PrivacyRepositoryInterface;


class PrivacyServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $singletons = [
            PrivacyRepositoryInterface::class => PrivacyRepository::class,
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
