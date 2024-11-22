<?php

namespace App\Modules\Profile;


use App\Modules\Profile\Application\UseCases\ChangeCoverPhotoUseCase;
use App\Modules\Profile\Application\UseCases\FetchUserProfileUseCase;
use App\Modules\Profile\Application\UseCases\UpdateProfilePictureUseCase;
use App\Modules\Profile\Domain\Repositories\ProfileRepositoryInterface;
use App\Modules\Profile\Infrastructure\Repositories\ProfileRepository;
use Illuminate\Support\ServiceProvider;

class ProfileServiceProvider extends ServiceProvider
{
    public function boot(): void {}

    public function register(): void
    {
        $singletons = [
            ChangeCoverPhotoUseCase::class => ChangeCoverPhotoUseCase::class,
            UpdateProfilePictureUseCase::class => UpdateProfilePictureUseCase::class,
            FetchUserProfileUseCase::class => FetchUserProfileUseCase::class,

            ProfileRepositoryInterface::class => ProfileRepository::class,
        ];

        foreach ($singletons as $abstract => $concrete) {
            $this->app->singleton(
                $abstract,
                $concrete,
            );
        }
    }
}
