<?php

namespace App\Modules\Auth;

use App\Modules\Auth\Application\Events\UserRegistered;
use App\Modules\Auth\Application\Listeners\UserRegisteredEventHandler;
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
use App\Modules\Auth\Domain\Interfaces\AuthRepositoryInterface;
use App\Modules\Auth\Domain\Interfaces\BlacklistedTokenRepositoryInterface;
use App\Modules\Auth\Domain\Interfaces\DeviceRepositoryInterface;
use App\Modules\Auth\Domain\Interfaces\UserOTPRepositoryInterface;
use App\Modules\Auth\Domain\Interfaces\UserRepositoryInterface;
use App\Modules\Auth\Infrastructure\Repositories\AuthRepository;
use App\Modules\Auth\Infrastructure\Repositories\BlacklistedTokenRepository;
use App\Modules\Auth\Infrastructure\Repositories\DeviceRepository;
use App\Modules\Auth\Infrastructure\Repositories\UserOtpRepository;
use App\Modules\Auth\Infrastructure\Repositories\UserRepository;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\ServiceProvider;


class AuthServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        // Register event mappings
        Event::listen(
            UserRegistered::class,
            [UserRegisteredEventHandler::class, 'handle']
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
            ForgotPasswordOtpVerifyUseCase::class => ForgotPasswordOtpVerifyUseCase::class,
            AccountOtpVerifyUseCase::class => AccountOtpVerifyUseCase::class,
            ForgotPasswordUseCase::class => ForgotPasswordUseCase::class,
            ResetPasswordUseCase::class => ResetPasswordUseCase::class,

            BlacklistedTokenRepositoryInterface::class => BlacklistedTokenRepository::class,
            DeviceRepositoryInterface::class => DeviceRepository::class,
            UserOTPRepositoryInterface::class => UserOtpRepository::class,
            UserRepositoryInterface::class => UserRepository::class,
            AuthRepositoryInterface::class => AuthRepository::class,
        ];

        foreach ($singletons as $abstract => $concrete) {
            $this->app->singleton(
                $abstract,
                $concrete,
            );
        }
    }
}
