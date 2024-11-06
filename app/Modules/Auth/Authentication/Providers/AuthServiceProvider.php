<?php

namespace App\Modules\Auth\Authentication\Providers;

use App\Modules\Auth\Authentication\Application\Events\UserRegistered;
use App\Modules\Auth\Authentication\Application\Listeners\SendWelcomeEmail;
use App\Modules\Auth\Authentication\Application\Services\JwtAccessTokenService;
use App\Modules\Auth\Authentication\Application\Services\JwtRefreshTokenService;
use App\Modules\Auth\Authentication\Application\UseCases\ForgotPasswordOTPCommandHandler;
use App\Modules\Auth\Authentication\Application\UseCases\LoginCommandHandler;
use App\Modules\Auth\Authentication\Application\UseCases\LogoutCommandHandler;
use App\Modules\Auth\Authentication\Application\UseCases\PasswordChangeCommandHandler;
use App\Modules\Auth\Authentication\Application\UseCases\RefreshTokenCommandHandler;
use App\Modules\Auth\Authentication\Application\UseCases\RegisterUserCommandHandler;
use App\Modules\Auth\Authentication\Application\UseCases\ReSendEmailVerifyingOTPCommandHandler;
use App\Modules\Auth\Authentication\Application\UseCases\ResetPasswordCommandHandler;
use App\Modules\Auth\Authentication\Application\UseCases\SendEmailVerifyingOTPCommandHandler;
use App\Modules\Auth\Authentication\Application\UseCases\VerifyEmailVerifyingOTPCommandHandler;
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
