<?php

namespace App\Modules\Auth;

use App\Modules\Auth\Application\Events\UserRegistered;
use App\Modules\Auth\Application\Listeners\SendWelcomeEmail;
use App\Modules\Auth\Application\Services\JwtAccessTokenService;
use App\Modules\Auth\Application\Services\JwtRefreshTokenService;
use App\Modules\Auth\Application\UseCases\AccountOtpVerifyUseCase;
use App\Modules\Auth\Application\UseCases\ChangePasswordUseCase;
use App\Modules\Auth\Application\UseCases\FetchRefreshTokenUseCase;
use App\Modules\Auth\Application\UseCases\ForgotPasswordOtpVerifyUseCase;
use App\Modules\Auth\Application\UseCases\ForgotPasswordUseCase;
use App\Modules\Auth\Application\UseCases\LogoutUserUseCase;
use App\Modules\Auth\Application\UseCases\RegisterUserUseCase;
use App\Modules\Auth\Application\UseCases\ReSendEmailVerifyingOTPUseCase;
use App\Modules\Auth\Application\UseCases\ResetPasswordUseCase;
use App\Modules\Auth\Application\UseCases\SendEmailVerifyingOTPUseCase;
use App\Modules\Auth\Application\UseCases\UserLoginUseCase;
use App\Modules\Auth\Domain\Interfaces\BlacklistedTokenRepositoryInterface;
use App\Modules\Auth\Domain\Interfaces\DeviceRepositoryInterface;
use App\Modules\Auth\Domain\Interfaces\UserOTPRepositoryInterface;
use App\Modules\Auth\Domain\Interfaces\UserRepositoryInterface;
use App\Modules\Auth\Infrastructure\Repositories\BlacklistedTokenRepositoryImpl;
use App\Modules\Auth\Infrastructure\Repositories\DeviceRepositoryImpl;
use App\Modules\Auth\Infrastructure\Repositories\UserOtpRepositoryInterfaceImpl;
use App\Modules\Auth\Infrastructure\Repositories\UserRepositoryInterfaceImpl;
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
            ForgotPasswordOtpVerifyUseCase::class => ForgotPasswordOtpVerifyUseCase::class,
            AccountOtpVerifyUseCase::class => AccountOtpVerifyUseCase::class,
            ForgotPasswordUseCase::class => ForgotPasswordUseCase::class,
            ResetPasswordUseCase::class => ResetPasswordUseCase::class,

            BlacklistedTokenRepositoryInterface::class => BlacklistedTokenRepositoryImpl::class,
            DeviceRepositoryInterface::class => DeviceRepositoryImpl::class,
            UserOTPRepositoryInterface::class => UserOtpRepositoryInterfaceImpl::class,
            UserRepositoryInterface::class => UserRepositoryInterfaceImpl::class,
        ];

        foreach ($singletons as $abstract => $concrete) {
            $this->app->singleton(
                $abstract,
                $concrete,
            );
        }
    }
}
