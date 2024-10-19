<?php

namespace App\Modules\Auth\Authentication\Providers;

use Illuminate\Support\Facades\Event;
use Illuminate\Support\ServiceProvider;
use App\Modules\Auth\Authentication\Events\UserRegistered;
use App\Modules\Auth\Authentication\Listeners\SendWelcomeEmail;
use App\Modules\Auth\Authentication\Services\JwtAccessTokenService;
use App\Modules\Auth\Authentication\Services\JwtRefreshTokenService;
use App\Modules\Auth\Authentication\UseCases\Commands\Login\LoginCommandHandler;
use App\Modules\Auth\Authentication\UseCases\Commands\Logout\LogoutCommandHandler;
use App\Modules\Auth\Authentication\UseCases\Commands\Register\RegisterUserCommandHandler;
use App\Modules\Auth\Authentication\UseCases\Commands\RefreshToken\RefreshTokenCommandHandler;
use App\Modules\Auth\Authentication\UseCases\Commands\ResetPassword\ResetPasswordCommandHandler;
use App\Modules\Auth\Authentication\UseCases\Commands\PasswordChange\PasswordChangeCommandHandler;
use App\Modules\Auth\Authentication\UseCases\Commands\ForgotPasswordOTP\ForgotPasswordOTPCommandHandler;
use App\Modules\Auth\Authentication\UseCases\Commands\SendEmailVerifyingOTP\SendEmailVerifyingOTPCommandHandler;
use App\Modules\Auth\Authentication\UseCases\Commands\ReSendEmailVerifyingOTP\ReSendEmailVerifyingOTPCommandHandler;
use App\Modules\Auth\Authentication\UseCases\Commands\VerifyEmailVerifyingOTP\VerifyEmailVerifyingOTPCommandHandler;

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

            LoginCommandHandler::class => LoginCommandHandler::class,
            RegisterUserCommandHandler::class => RegisterUserCommandHandler::class,
            PasswordChangeCommandHandler::class => PasswordChangeCommandHandler::class,
            RefreshTokenCommandHandler::class => RefreshTokenCommandHandler::class,
            LogoutCommandHandler::class => LogoutCommandHandler::class,
            ReSendEmailVerifyingOTPCommandHandler::class => ReSendEmailVerifyingOTPCommandHandler::class,
            SendEmailVerifyingOTPCommandHandler::class => SendEmailVerifyingOTPCommandHandler::class,
            VerifyEmailVerifyingOTPCommandHandler::class => VerifyEmailVerifyingOTPCommandHandler::class,
            ForgotPasswordOTPCommandHandler::class => ForgotPasswordOTPCommandHandler::class,
            ResetPasswordCommandHandler::class => ResetPasswordCommandHandler::class,
        ];

        foreach ($singletons as $abstract => $concrete) {
            $this->app->singleton(
                $abstract,
                $concrete,
            );
        }
    }
}
