<?php

namespace App\Modules\Auth\Authentication;

use App\Modules\Auth\Authentication\Application\Events\UserRegistered;
use App\Modules\Auth\Authentication\Application\Listeners\SendWelcomeEmail;
use App\Modules\Auth\Authentication\Application\Services\JwtAccessTokenService;
use App\Modules\Auth\Authentication\Application\Services\JwtRefreshTokenService;
use App\Modules\Auth\Authentication\Application\UseCases\BlacklistedTokenExistQueryHandler;
use App\Modules\Auth\Authentication\Application\UseCases\FetchUserProfileUseCase;
use App\Modules\Auth\Authentication\Application\UseCases\ForgotPasswordUseCase;
use App\Modules\Auth\Authentication\Application\UseCases\UserLoginUseCase;
use App\Modules\Auth\Authentication\Application\UseCases\LogoutUserUseCase;
use App\Modules\Auth\Authentication\Application\UseCases\ChangePasswordUseCase;
use App\Modules\Auth\Authentication\Application\UseCases\FetchRefreshTokenUseCase;
use App\Modules\Auth\Authentication\Application\UseCases\RegisterUserUseCase;
use App\Modules\Auth\Authentication\Application\UseCases\ReSendEmailVerifyingOTPUseCase;
use App\Modules\Auth\Authentication\Application\UseCases\ResetPasswordUseCase;
use App\Modules\Auth\Authentication\Application\UseCases\SendEmailVerifyingOTPUseCase;
use App\Modules\Auth\Authentication\Application\UseCases\ChangeCoverPhotoUseCase;
use App\Modules\Auth\Authentication\Application\UseCases\UpdateProfilePictureUseCase;
use App\Modules\Auth\Authentication\Application\UseCases\AccountOtpVerifyUseCase;
use App\Modules\Auth\Authentication\Application\UseCases\ForgotPasswordOtpVerifyUseCase;
use App\Modules\Auth\Authentication\Domain\Interfaces\BlacklistedTokenRepositoryInterface;
use App\Modules\Auth\Authentication\Domain\Interfaces\DeviceRepositoryInterface;
use App\Modules\Auth\Authentication\Domain\Interfaces\UserOTPRepositoryInterface;
use App\Modules\Auth\Authentication\Domain\Interfaces\UserRepositoryInterface;
use App\Modules\Auth\Authentication\Infrastructure\Repositories\BlacklistedTokenRepositoryImpl;
use App\Modules\Auth\Authentication\Infrastructure\Repositories\DeviceRepositoryImpl;
use App\Modules\Auth\Authentication\Infrastructure\Repositories\UserOtpRepositoryInterfaceImpl;
use App\Modules\Auth\Authentication\Infrastructure\Repositories\UserRepositoryInterfaceImpl;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\ServiceProvider;


class AuthServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        // Register event mappings
        Event::listen(
            UserRegistered::class,
            [SendWelcomeEmail::class, 'handle']
        );
    }

    public function register(): void
    {
        $singletons = [
            JwtAccessTokenService::class => JwtAccessTokenService::class,
            JwtRefreshTokenService::class => JwtRefreshTokenService::class,

            UserLoginUseCase::class => UserLoginUseCase::class,
            RegisterUserUseCase::class => RegisterUserUseCase::class,
            ChangePasswordUseCase::class => ChangePasswordUseCase::class,
            FetchRefreshTokenUseCase::class => FetchRefreshTokenUseCase::class,
            LogoutUserUseCase::class => LogoutUserUseCase::class,
            ReSendEmailVerifyingOTPUseCase::class => ReSendEmailVerifyingOTPUseCase::class,
            SendEmailVerifyingOTPUseCase::class => SendEmailVerifyingOTPUseCase::class,
            AccountOtpVerifyUseCase::class => AccountOtpVerifyUseCase::class,
            ForgotPasswordUseCase::class => ForgotPasswordUseCase::class,
            ResetPasswordUseCase::class => ResetPasswordUseCase::class,

            BlacklistedTokenRepositoryInterface::class => BlacklistedTokenRepositoryImpl::class,
            BlacklistedTokenExistQueryHandler::class => BlacklistedTokenExistQueryHandler::class,

            DeviceRepositoryInterface::class => DeviceRepositoryImpl::class,

            UserOTPRepositoryInterface::class => UserOtpRepositoryInterfaceImpl::class,
            ForgotPasswordOtpVerifyUseCase::class => ForgotPasswordOtpVerifyUseCase::class,

            UserRepositoryInterface::class => UserRepositoryInterfaceImpl::class,
            JwtAccessTokenService::class => JwtAccessTokenService::class,
            JwtRefreshTokenService::class => JwtRefreshTokenService::class,

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
