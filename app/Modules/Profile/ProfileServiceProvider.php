<?php

namespace App\Modules\Profile;


use Illuminate\Support\ServiceProvider;
use App\Modules\Profile\Application\UseCases\ChangeCoverPhotoUseCase;
use App\Modules\Profile\Application\UseCases\FetchUserProfileUseCase;
use App\Modules\Profile\Application\UseCases\UpdateProfilePictureUseCase;
use App\Modules\Profile\Domain\Interfaces\ProfileRepositoryInterface;
use App\Modules\Profile\Infrastructure\Interfaces\UserProfileRepository;

class ProfileServiceProvider extends ServiceProvider
{
    public function boot(): void {}

    public function register(): void
    {
        $singletons = [
            ChangeCoverPhotoUseCase::class => ChangeCoverPhotoUseCase::class,
            UpdateProfilePictureUseCase::class => UpdateProfilePictureUseCase::class,
            FetchUserProfileUseCase::class => FetchUserProfileUseCase::class,

            ProfileRepositoryInterface::class => UserProfileRepository::class,
        ];

        foreach ($singletons as $abstract => $concrete) {
            $this->app->singleton(
                $abstract,
                $concrete,
            );
        }
    }
}
