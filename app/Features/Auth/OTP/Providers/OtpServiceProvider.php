<?php

namespace App\Features\Auth\OTP\Providers;

use App\Core\Bus\IQueryBus;
use App\Core\Bus\ICommandBus;
use Carbon\Laravel\ServiceProvider;
use App\Features\Auth\OTP\Interfaces\UserOTPRepositoryInterface;
use App\Features\Auth\OTP\Repositories\UserOtpRepositoryInterfaceImpl;
use App\Features\Auth\OTP\UseCases\Commands\CreateUserOTP\CreateUserOTPCommand;
use App\Features\Auth\OTP\UseCases\Commands\UpdateUserOTP\UpdateUserOTPCommand;
use App\Features\Auth\OTP\UseCases\Queries\FindUserOtp\FindUserOTPByUserIdQuery;
use App\Features\Auth\OTP\UseCases\Commands\CreateUserOTP\CreateUserOTPCommandHandler;
use App\Features\Auth\OTP\UseCases\Commands\UpdateUserOTP\UpdateUserOTPCommandHandler;
use App\Features\Auth\OTP\UseCases\Queries\FindUserOtp\FindUserOTPByUserIdQueryHandler;
use App\Features\Auth\OTP\UseCases\Commands\VerifyForgotPasswordOTP\VerifyForgotPasswordOTPCommand;
use App\Features\Auth\OTP\UseCases\Commands\VerifyForgotPasswordOTP\VerifyForgotPasswordOTPCommandHandler;

class OtpServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        // Register command mappings
        $commandBus = app(ICommandBus::class);

        $commandBus->register([
            CreateUserOTPCommand::class => CreateUserOTPCommandHandler::class,
            VerifyForgotPasswordOTPCommand::class => VerifyForgotPasswordOTPCommandHandler::class,
            UpdateUserOTPCommand::class => UpdateUserOTPCommandHandler::class,
        ]);

        $queryBus = app(IQueryBus::class);

        $queryBus->register([
            FindUserOTPByUserIdQuery::class => FindUserOTPByUserIdQueryHandler::class,
        ]);
    }

    public function register(): void
    {
        $singletons = [
            UserOTPRepositoryInterface::class => UserOtpRepositoryInterfaceImpl::class,
        ];

        foreach ($singletons as $abstract => $concrete) {
            $this->app->singleton(
                $abstract,
                $concrete,
            );
        }
    }
}
