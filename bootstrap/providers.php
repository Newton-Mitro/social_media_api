<?php

return [
    \App\Core\Providers\AppServiceProvider::class,
    \App\Features\Auth\Authentication\Providers\AuthServiceProvider::class,
    \App\Features\Auth\User\Providers\UserServiceProvider::class,
    \App\Features\Post\Providers\PostServiceProvider::class,
    \App\Features\Auth\Device\Providers\DeviceServiceProvider::class,
    \App\Features\Auth\BlacklistedToken\Providers\BlacklistedTokenServiceProvider::class,
    \App\Features\Auth\OTP\Providers\OtpServiceProvider::class,
    \App\Features\Auth\Privacy\Providers\PrivacyServiceProvider::class,
];