<?php

namespace App\Features\Auth\Authentication\Providers;

use App\Core\Bus\IQueryBus;
use App\Core\Bus\ICommandBus;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\ServiceProvider;
use App\Features\Auth\Authentication\Events\UserRegistered;
use App\Features\Auth\Authentication\Listeners\SendWelcomeEmail;
use App\Features\Auth\Authentication\Services\JwtEmailTokenService;
use App\Features\Auth\Authentication\Services\JwtAccessTokenService;
use App\Features\Auth\Authentication\Services\JwtRefreshTokenService;
use App\Features\Auth\Authentication\UseCases\Commands\Login\LoginCommand;
use App\Features\Auth\Authentication\Services\JwtForgotPasswordTokenService;
use App\Features\Auth\Authentication\UseCases\Commands\Logout\LogoutCommand;
use App\Features\Auth\Authentication\UseCases\Commands\Login\LoginCommandHandler;
use App\Features\Auth\Authentication\UseCases\Commands\Logout\LogoutCommandHandler;
use App\Features\Auth\Authentication\UseCases\Commands\Register\RegisterUserCommand;
use App\Features\Auth\Authentication\UseCases\Commands\RefreshToken\RefreshTokenCommand;
use App\Features\Auth\Authentication\UseCases\Commands\ResetPassword\ResetPasswordCommand;
use App\Features\Auth\Authentication\UseCases\Commands\Register\RegisterUserCommandHandler;
use App\Features\Auth\Authentication\UseCases\Commands\PasswordChange\PasswordChangeCommand;
use App\Features\Auth\Authentication\UseCases\Commands\RefreshToken\RefreshTokenCommandHandler;
use App\Features\Auth\Authentication\UseCases\Commands\ResetPassword\ResetPasswordCommandHandler;
use App\Features\Auth\Authentication\UseCases\Commands\ForgotPasswordOTP\ForgotPasswordOTPCommand;
use App\Features\Auth\Authentication\UseCases\Commands\PasswordChange\PasswordChangeCommandHandler;
use App\Features\Auth\Authentication\UseCases\Commands\ForgotPasswordOTP\ForgotPasswordOTPCommandHandler;
use App\Features\Auth\Authentication\UseCases\Commands\SendEmailVerifyingOTP\SendEmailVerifyingOTPCommand;
use App\Features\Auth\Authentication\UseCases\Commands\ReSendEmailVerifyingOTP\ReSendEmailVerifyingOTPCommand;
use App\Features\Auth\Authentication\UseCases\Commands\VerifyEmailVerifyingOTP\VerifyEmailVerifyingOTPCommand;
use App\Features\Auth\Authentication\UseCases\Commands\SendEmailVerifyingOTP\SendEmailVerifyingOTPCommandHandler;
use App\Features\Auth\Authentication\UseCases\Commands\ReSendEmailVerifyingOTP\ReSendEmailVerifyingOTPCommandHandler;
use App\Features\Auth\Authentication\UseCases\Commands\VerifyEmailVerifyingOTP\VerifyEmailVerifyingOTPCommandHandler;

class AuthServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        // Register command mappings
        $commandBus = app(ICommandBus::class);

        $commandBus->register([
            LoginCommand::class => LoginCommandHandler::class,
            RegisterUserCommand::class => RegisterUserCommandHandler::class,
            PasswordChangeCommand::class => PasswordChangeCommandHandler::class,
            RefreshTokenCommand::class => RefreshTokenCommandHandler::class,
            LogoutCommand::class => LogoutCommandHandler::class,
            ReSendEmailVerifyingOTPCommand::class => ReSendEmailVerifyingOTPCommandHandler::class,
            SendEmailVerifyingOTPCommand::class => SendEmailVerifyingOTPCommandHandler::class,
            VerifyEmailVerifyingOTPCommand::class => VerifyEmailVerifyingOTPCommandHandler::class,
            ForgotPasswordOTPCommand::class => ForgotPasswordOTPCommandHandler::class,
            ResetPasswordCommand::class => ResetPasswordCommandHandler::class,
        ]);

        // Register query mappings
        $queryBus = app(IQueryBus::class);

        $queryBus->register([
        ]);

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
            JwtForgotPasswordTokenService::class => JwtForgotPasswordTokenService::class,
            JwtEmailTokenService::class => JwtEmailTokenService::class,
        ];

        foreach ($singletons as $abstract => $concrete) {
            $this->app->singleton(
                $abstract,
                $concrete,
            );
        }
    }
}