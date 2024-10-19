<?php

namespace App\Modules\Auth\OTP\Providers;

use Carbon\Laravel\ServiceProvider;
use App\Modules\Auth\OTP\Interfaces\UserOTPRepositoryInterface;
use App\Modules\Auth\OTP\Repositories\UserOtpRepositoryInterfaceImpl;
use App\Modules\Auth\OTP\UseCases\Commands\CreateUserOTP\CreateUserOTPCommandHandler;
use App\Modules\Auth\OTP\UseCases\Commands\UpdateUserOTP\UpdateUserOTPCommandHandler;
use App\Modules\Auth\OTP\UseCases\Queries\FindUserOtp\FindUserOTPByUserIdQueryHandler;
use App\Modules\Auth\OTP\UseCases\Commands\VerifyForgotPasswordOTP\VerifyForgotPasswordOTPCommandHandler;

class OtpServiceProvider extends ServiceProvider
{
    public function boot(): void {}

    public function register(): void
    {
        $singletons = [
            UserOTPRepositoryInterface::class => UserOtpRepositoryInterfaceImpl::class,

            CreateUserOTPCommandHandler::class => CreateUserOTPCommandHandler::class,
            VerifyForgotPasswordOTPCommandHandler::class => VerifyForgotPasswordOTPCommandHandler::class,
            UpdateUserOTPCommandHandler::class => UpdateUserOTPCommandHandler::class,

            FindUserOTPByUserIdQueryHandler::class => FindUserOTPByUserIdQueryHandler::class,
        ];

        foreach ($singletons as $abstract => $concrete) {
            $this->app->singleton(
                $abstract,
                $concrete,
            );
        }
    }
}
