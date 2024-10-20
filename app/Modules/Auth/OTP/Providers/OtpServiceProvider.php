<?php

namespace App\Modules\Auth\OTP\Providers;

use Carbon\Laravel\ServiceProvider;
use App\Modules\Auth\OTP\Interfaces\UserOTPRepositoryInterface;
use App\Modules\Auth\OTP\Repositories\UserOtpRepositoryInterfaceImpl;
use App\Modules\Auth\OTP\UseCases\Commands\VerifyForgotPasswordOTP\VerifyForgotPasswordOTPCommandHandler;

class OtpServiceProvider extends ServiceProvider
{
    public function boot(): void {}

    public function register(): void
    {
        $singletons = [
            UserOTPRepositoryInterface::class => UserOtpRepositoryInterfaceImpl::class,

            VerifyForgotPasswordOTPCommandHandler::class => VerifyForgotPasswordOTPCommandHandler::class,
        ];

        foreach ($singletons as $abstract => $concrete) {
            $this->app->singleton(
                $abstract,
                $concrete,
            );
        }
    }
}
