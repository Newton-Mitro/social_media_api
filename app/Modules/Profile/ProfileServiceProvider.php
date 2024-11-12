<?php

namespace App\Modules\Profile;


use Illuminate\Support\ServiceProvider;
use App\Modules\Profile\Application\UseCases\ChangeCoverPhotoUseCase;
use App\Modules\Profile\Application\UseCases\FetchUserProfileUseCase;
use App\Modules\Profile\Application\UseCases\UpdateProfilePictureUseCase;


class ProfileServiceProvider extends ServiceProvider
{
    public function boot(): void {}

    public function register(): void
    {
        $singletons = [
            ChangeCoverPhotoUseCase::class => ChangeCoverPhotoUseCase::class,
            UpdateProfilePictureUseCase::class => UpdateProfilePictureUseCase::class,
            FetchUserProfileUseCase::class => FetchUserProfileUseCase::class,
        ];

        foreach ($singletons as $abstract => $concrete) {
            $this->app->singleton(
                $abstract,
                $concrete,
            );
        }
    }
}
